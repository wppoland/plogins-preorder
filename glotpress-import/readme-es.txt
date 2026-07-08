=== Plogins Preorder - Pre-Orders for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, preorder, pre-order, backorder, out of stock
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.1
Requiere complementos: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Permita que los clientes realicen pedidos anticipados de productos WooCommerce próximos o agotados con un botón personalizado para añadir al carrito.

== Description ==

El pedido anticipado le permite vender productos WooCommerce antes de que estén disponibles. Marque una casilla
en el producto y permanece adquirible incluso cuando su estado de existencias está agotado
stock, por lo que un cliente puede reservar un próximo lanzamiento o un reabastecimiento en lugar de
aterrizando en una página muerta de "agotado".

En el escaparate, los productos pedidos por adelantado obtienen una etiqueta personalizada para añadir al carrito (por ejemplo
"Reservar ahora"), y cada línea de pedido anticipado se marca en el carrito y se copia en
el pedido, para que pueda diferenciar los pedidos anticipados al empacar y enviar.

= Documentation and links =

* <strong>Documentación</strong> - https://plogins.com/es/plogins-preorder/docs/
* <strong>Página de complementos</strong> - https://plogins.com/es/plogins-preorder/
* <strong>Código fuente</strong> - https://github.com/wppoland/plogins-preorder
* <strong>Informes de errores y solicitudes de funciones</strong> - https://github.com/wppoland/plogins-preorder/issues


= Features =

* Una casilla de verificación <strong>Pre-pedido</strong> en cada producto, en <strong>Datos del producto → General</strong>.
* Una etiqueta personalizada para añadir al carrito para productos en preventa, configurada en toda la tienda.
* Los productos reservados se pueden comprar mientras su estado de existencias esté agotado.
* El carrito y el proceso de pago muestran una fila "Pedido anticipado: Sí" en cada línea de pedido anticipado.
* Esa bandera se copia en la línea de pedido del pedido, por lo que se muestra en la pantalla del pedido y en los albaranes.
* Una pantalla <strong>WooCommerce → Pedidos anticipados</strong> con un interruptor de encendido/apagado para toda la tienda y el texto del botón predeterminado.
* Al pausar el interruptor de encendido/apagado, los productos marcados se comportan nuevamente como productos normales, sin editar cada uno.
* Los formularios no están verificados y están limitados a usuarios que pueden administrar WooCommerce; la salida se escapa y la entrada se desinfecta.
* Se envía con una plantilla de traducción (plogins-preorder.pot) y una traducción al polaco; Al eliminar el complemento se elimina tu configuración.
* Funciona con WooCommerce HPOS y los bloques de carrito y pago.

== Installation ==

1. Cargue el complemento en `/wp-content/plugins/preorder`, o instálelo a través de Complementos → Añadir nuevo.
2. Actívalo. WooCommerce debe estar activo.
3. Edite un producto, abra <strong>Datos del producto → General</strong> y marque <strong>Reservar<strong>. 4. Ajuste los valores predeterminados de toda la tienda en </strong>WooCommerce → Pedidos anticipados</strong>.

== Frequently Asked Questions ==

= Does it require WooCommerce? =

Sí. WooCommerce debe estar instalado y activo.

= What happens when a product is marked as a pre-order? =

Se puede comprar incluso cuando está agotado, su etiqueta del botón Añadir al carrito
cambios, y el carrito y las líneas de pedido se marcan como pedidos anticipados.

= Can I pause pre-orders without editing every product? =

Sí. Desactive la opción global en <strong>WooCommerce → Pedidos anticipados</strong> y marque
Los productos se comportan como productos normales hasta que los vuelves a encender.

= Can guests buy pre-order products? =

Sí, cuando el producto se puede comprar y su tienda permite el pago como invitado.

= How are pre-orders shown in the cart? =

Los artículos del carrito y de las líneas de pedido se marcan para que tú y el cliente puedan ver qué líneas son pedidos anticipados.


= Does this plugin work on WordPress Multisite? =

Sí. Este complemento es compatible con WordPress Multisite. Activarlo en red o activarlo en sitios individuales; Cada sitio mantiene su propia configuración y datos.

== Screenshots ==

1. El campo de pedido anticipado en el editor de productos de WooCommerce.
2. La pantalla de configuración de pedidos anticipados de WooCommerce →.

== External Services ==

El pedido anticipado no se conecta a ningún servicio externo. No hace HTTP saliente
solicita, no carga scripts, fuentes o análisis remotos y no envía datos
tu sitio. Todo se ejecuta en tu propia instalación de WordPress: el botón para toda la tienda
El texto y el interruptor de encendido/apagado se encuentran en la opción `preorder_settings`, el valor por producto
El indicador se almacena como el meta del producto `_preorder_enabled`, y cada pedido anticipado
La línea lleva un metavalor de línea de pedido "Pre-pedido: Sí". No se envía ningún correo electrónico por parte del
complemento.

== Changelog ==

= 1.0.1 =
* Primera versión estable.

= 0.1.3 =
* Renombrado a Plogins Preorder para WooCommerce para obtener un nombre de complemento más distintivo.

= 0.1.2 =
* Campo de fecha de lanzamiento esperada en productos (filtro `ProductMeta::META_RELEASE_DATE`, `preorder/release_date`).
* La fecha de lanzamiento se muestra en el talón de pedido anticipado del escaparate y en la variación JSON.
* Meta oculta del elemento de pedido `_preorder_line` para consultas complementarias.

= 0.1.1 =
* Añade el filtro `preorder/is_preorder` y la herencia de variaciones en `ProductMeta`.
* Exponer el estado del pedido anticipado por variación en el formulario de variaciones para complementos.

= 0.1.0 =
* Lanzamiento inicial: indicador de pedido anticipado por producto, texto de botón personalizado, posibilidad de compra de existencias agotadas y marcado de carrito y pedido, con una pantalla de configuración.
