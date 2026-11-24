# plantae-lukavec.cz

## Faktury

Faktura se přikládá pouze k zákaznickému e-mailu „čeká na vyřízení“ (`customer_on_hold_order`); výjimka pro platbu na místě zůstává zachována. E-mail „zpracovává se“ (`customer_processing_order`) se odesílá bez faktury. Aktualizace faktury ve FakturaOnline při přechodu do zpracování zůstává zachována.

Regresní kontrola příloh bez připojení k FakturaOnline:

```sh
docker run --rm --network none -v "$PWD:/app:ro" -w /app --entrypoint php wordpress:php8.4-apache tests/invoice-email-attachments.php
```
