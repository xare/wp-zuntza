# wp-zuntza

WP Zuntza, zuntza optikoaren lokalizatatzailearen wordpress-erako plugin-a.

Zuntza zure kalean dagoen ala ez egiaztatzeko aski duzu
1. Helbidea.dom/zuntza helbidera jotzea
2. Bertan dagoen formulategia betetzeak, ez duzu zertan ezer idatzi behar,
3. Formulategiko kontrolaren azpiko loturetan lehenik herrialdeak hautatzeko aukera daukazu,
4. Behin herrialdea haututa udalaren zerrenda agertuko zaizu.
5. Hiria hautatua kalea agertuko zaizu
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