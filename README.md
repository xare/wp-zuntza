# wp-zuntza

WP Zuntza, zuntza optikoaren lokalizatzailearen wordpress-erako plugin-a.

Zuntza optikoa zure kalean dagoen ala ez egiaztatzeko honako urratsak jarraitu:
1. /zuntza helbidera jo.
2. Bertan dagoen formulategia bete, ez duzu zertan ezer idatzi behar.
3. Formulategiko kontrolaren azpiko loturetan lehenik herrialdeak hautatu.
4. Behin herrialdea haututa udalaren zerrenda agertuko zaizu.
5. Hiria hautatua kalea agertuko zaizu.
6. Eta kalean hautatuta zenbakia hautatzea daukazu.

Hori eginda egiaztatuta duzu dagoen helbidean zuntza optikoa iritsi den hala ez.

## Backend (Admin) aldetik

1. /wp-admin/admin.php?page=zuntza azken csv fitxategia hautatu eta kargatzeko aukera ematen dizu.
2. Horri berri bat sortu, eta bertan txertatu erabiltzailearen formulategian jartzeko. Kode hau ere widget batean sar daiteke.
```
<!-- wp:shortcode -->
[zuntza_form]
<!-- /wp:shortcode -->
````