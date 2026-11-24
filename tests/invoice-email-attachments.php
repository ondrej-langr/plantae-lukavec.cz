<?php

namespace App {
    class FakturaOnlineClient {
        public static array $calls = [];
        public static int $invoiceId;

        function createInvoice($invoice) {
            self::$calls[] = 'create';
            return (object) ['invoice_id' => self::$invoiceId];
        }

        function updateInvoice($invoiceId, $invoice) {
            self::$calls[] = 'update';
        }

        function getPdfForInvoice($invoiceId) {
            self::$calls[] = 'pdf';
            return '%PDF-test-invoice';
        }
    }
}

namespace App\Models {
    class FakturaOnline {
        static function fromWpOrder($order) {
            return new self();
        }
    }
}

namespace {
    class WC_Order {
        function __construct(private string $paymentMethod = 'bacs') {}
        function get_id() { return 123; }
        function get_payment_method() { return $this->paymentMethod; }
    }

    $filters = [];
    $metadata = [];

    function add_action(...$args) {}
    function add_filter($name, $callback, ...$args) {
        $GLOBALS['filters'][$name] = $callback;
    }
    function get_post_meta($orderId, $key, $single) {
        return $GLOBALS['metadata'][$orderId][$key] ?? '';
    }
    function add_post_meta($orderId, $key, $value, $unique) {
        $GLOBALS['metadata'][$orderId][$key] = $value;
    }
    function check($condition, $message) {
        if (!$condition) {
            throw new \RuntimeException($message);
        }
    }

    require __DIR__ . '/../src/Hook.php';
    require __DIR__ . '/../src/Hooks/WoocommerceInvoices.php';

    new \App\Hooks\WoocommerceInvoices();
    $attachments = $filters['woocommerce_email_attachments'];
    $order = new WC_Order();
    $existing = ['existing-attachment.pdf'];
    \App\FakturaOnlineClient::$invoiceId = random_int(100000000, 999999999);
    $directory = sys_get_temp_dir() . '/invoices';
    $directoryExisted = is_dir($directory);
    $pdf = $directory . '/faktura-' . \App\FakturaOnlineClient::$invoiceId . '.pdf';

    try {
        check($attachments($existing, 'customer_processing_order', $order, null) === $existing,
            'Processing email must not create or attach an invoice, even without an existing invoice.');
        check(\App\FakturaOnlineClient::$calls === [], 'Processing email must not call the invoice API.');

        $result = $attachments($existing, 'customer_on_hold_order', $order, null);
        check($result === [...$existing, $pdf], 'Initial on-hold email must retain attachments and add the invoice.');
        check(file_get_contents($pdf) === '%PDF-test-invoice', 'The attached invoice must contain the downloaded PDF.');
        check(\App\FakturaOnlineClient::$calls === ['create', 'pdf'], 'Initial email must create and download the invoice.');
        check(get_post_meta(123, 'fakturaonline_invoice_id', true) === \App\FakturaOnlineClient::$invoiceId,
            'The created invoice must remain linked to the order.');

        \App\FakturaOnlineClient::$calls = [];
        check($attachments($existing, 'customer_processing_order', $order, null) === $existing,
            'On-hold to processing must not resend the linked invoice.');
        check($attachments($existing, 'customer_completed_order', $order, null) === $existing,
            'Completed email must retain its original attachments.');
        check($attachments($existing, 'customer_on_hold_order', new WC_Order('alg_custom_gateway_1'), null) === $existing,
            'Local-payment orders must remain excluded.');
        check($attachments($existing, 'customer_on_hold_order', null, null) === $existing,
            'Non-order emails must retain their original attachments.');
        check(\App\FakturaOnlineClient::$calls === [], 'Excluded emails must not call the invoice API.');

        echo "PASS: initial invoice attachment, processing exclusion, and existing exclusions\n";
    } finally {
        if (is_file($pdf)) {
            unlink($pdf);
        }
        if (!$directoryExisted && is_dir($directory)) {
            rmdir($directory);
        }
    }
}
