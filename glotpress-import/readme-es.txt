=== Plogins Preorder - Pre-Orders for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, preorder, pre-order, backorder, out of stock
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.2
Requires Plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Permite que tus clientes reserven productos de WooCommerce próximos o agotados con un botón personalizado para añadir al carrito.

== Description ==

Plogins Preorder te permite vender productos de WooCommerce antes de que estén en stock. Marca una casilla
en el producto y seguirá disponible para la compra incluso cuando su estado de stock sea agotado,
de modo que un cliente pueda reservar un próximo lanzamiento o una reposición en lugar de
aterrizar en una página muerta de «agotado».

En la tienda, los productos en preventa reciben una etiqueta personalizada para el botón de añadir al carrito (por ejemplo
«Reservar ahora»), y cada línea de preventa se marca en el carrito y se copia en
el pedido, para que puedas distinguir las preventas al empaquetar y enviar.

= Documentation and links =

* <strong>Documentación</strong> - https://plogins.com/es/plogins-preorder/docs/
* <strong>Página del plugin</strong> - https://plogins.com/es/plogins-preorder/
* <strong>Código fuente</strong> - https://github.com/wppoland/plogins-preorder
* <strong>Informes de errores y solicitudes de funciones</strong> - https://github.com/wppoland/plogins-preorder/issues


= Features =

* Una casilla <strong>Preventa</strong> en cada producto, en <strong>Datos del producto → General</strong>.
* Una etiqueta personalizada para el botón de añadir al carrito de los productos en preventa, configurada para toda la tienda.
* Los productos en preventa siguen disponibles para la compra mientras su estado de stock sea agotado.
* El carrito y el pago muestran una fila «Preventa: Sí» en cada línea de preventa.
* Esa marca se copia en la línea del pedido, así que aparece en la pantalla del pedido y en los albaranes.
* Una pantalla <strong>WooCommerce → Preventas</strong> con un interruptor de encendido/apagado para toda la tienda y el texto de botón por defecto.
* Al desactivar el interruptor, los productos marcados vuelven a comportarse como productos normales, sin editar cada uno.
* Los formularios están verificados con nonce y limitados a usuarios que pueden gestionar WooCommerce; la salida se escapa y la entrada se sanea.
* Se distribuye con una plantilla de traducción (plogins-preorder.pot) y una traducción al polaco; al eliminar el plugin se borra su ajuste.
* Funciona con WooCommerce HPOS y los bloques de carrito y pago.

== Installation ==

1. Sube el plugin a `/wp-content/plugins/preorder`, o instálalo desde Plugins → Añadir nuevo.
2. Actívalo. WooCommerce debe estar activo.
3. Edita un producto, abre <strong>Datos del producto → General</strong> y marca <strong>Preventa</strong>.
4. Ajusta los valores por defecto de toda la tienda en <strong>WooCommerce → Preventas</strong>.

== Frequently Asked Questions ==

= Does it require WooCommerce? =

Sí. WooCommerce debe estar instalado y activo.

= What happens when a product is marked as a pre-order? =

Pasa a estar disponible para la compra incluso cuando está agotado, la etiqueta de su botón de añadir al carrito
cambia, y las líneas del carrito y del pedido se marcan como preventas.

= Can I pause pre-orders without editing every product? =

Sí. Desactiva el interruptor global en <strong>WooCommerce → Preventas</strong> y los productos
marcados se comportan como productos normales hasta que lo vuelvas a activar.

= Can guests buy pre-order products? =

Sí, cuando el producto se puede comprar y tu tienda permite el pago como invitado.

= How are pre-orders shown in the cart? =

Los artículos del carrito y las líneas del pedido se marcan para que tú y el cliente veáis qué líneas son preventas.


= Does this plugin work on WordPress Multisite? =

Sí. Este plugin es compatible con WordPress Multisite. Actívalo en toda la red o en sitios individuales; cada sitio conserva sus propios ajustes y datos.

== Screenshots ==

1. El campo de preventa en el editor de productos de WooCommerce.
2. La pantalla de ajustes WooCommerce → Preventas.

== External Services ==

Plogins Preorder no se conecta a ningún servicio externo. No hace peticiones HTTP salientes,
no carga scripts, fuentes ni analíticas remotas y no envía ningún dato fuera de
tu sitio. Todo se ejecuta en tu propia instalación de WordPress: el texto del botón para toda la tienda
y el interruptor de encendido/apagado residen en la opción `preorder_settings`, la marca por producto
se guarda como el meta de producto `_preorder_enabled`, y cada línea de pedido en preventa
lleva un valor meta de línea «Preventa: Sí». El plugin no envía ningún
correo electrónico.

== Translations ==

Plogins Preorder incluye traducciones al polaco, alemán y español de la interfaz del plugin. El dominio de texto es `plogins-preorder`, de modo que los paquetes de idioma de WordPress.org también pueden sobrescribir o ampliar estas traducciones incluidas.

== Changelog ==

= 1.0.2 =
* Añadidas traducciones al polaco, alemán y español de la interfaz del plugin.

= 1.0.1 =
* Primera versión estable.

= 0.1.3 =
* Renombrado a Plogins Preorder for WooCommerce para tener un nombre de plugin más distintivo.

= 0.1.2 =
* Campo de fecha de lanzamiento prevista en los productos (`ProductMeta::META_RELEASE_DATE`, filtro `preorder/release_date`).
* Fecha de lanzamiento mostrada en el resumen de preventa de la tienda y en el JSON de variaciones.
* Meta oculto de línea de pedido `_preorder_line` para consultas de complementos.

= 0.1.1 =
* Añadido el filtro `preorder/is_preorder` y la herencia de variaciones en `ProductMeta`.
* Expuesto el estado de preventa por variación en el formulario de variaciones para complementos.

= 0.1.0 =
* Lanzamiento inicial: marca de preventa por producto, texto de botón personalizado, posibilidad de compra con stock agotado y marcado de carrito y pedido, con una pantalla de ajustes.
