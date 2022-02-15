use xoxoctic;

create table icons(
	id int auto_increment,
    grupo varchar(50) not null,
    iconame varchar(50) not null,
    icon varchar(50) not null,
    primary key(id)
);

drop table icons;

insert into icons (grupo, iconame, icon) values ('bakery', 'Pan y trigo' , '001-wheat.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Sandwich' , '003-sandwich.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Pie de manzana' , '004-apple-pie.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Muffin' , '005-muffin.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Leche' , '006-milk.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Pan' , '007-loaf.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Helado' , '008-ice-cream.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Miel' , '009-honey.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Harina' , '010-flour.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Huevos' , '011-eggs.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Dona' , '012-donut.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Cupcake' , '013-cupcake.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Croissant' , '014-croissant.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Crepe' , '015-crepe.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Galleta' , '016-cookie.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Barra de Chocolate' , '018-chocolate-bar.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Queso' , '019-cheese.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Cereal' , '020-cereal.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Pastel' , '021-cake-slice.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Pastel de Cumpleaños' , '023-birthday-cake.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Canasta' , '024-bakery.svg');
insert into icons (grupo, iconame, icon) values ('bakery', 'Baguette' , '025-baguette.svg');

/* Beer */ 
insert into icons (grupo, iconame, icon) values ('beer', 'Cerveza' , '001-beer.svg');
insert into icons (grupo, iconame, icon) values ('beer', 'Hamburguesa' , '002-burger.svg');
insert into icons (grupo, iconame, icon) values ('beer', 'Fruta' , '005-fruit.svg');
insert into icons (grupo, iconame, icon) values ('beer', 'Cerveza 2' , '011-beer.svg');
insert into icons (grupo, iconame, icon) values ('beer', 'Balde' , '014-bucket.svg');
insert into icons (grupo, iconame, icon) values ('beer', 'Cerveza 3' , '016-beer.svg');
insert into icons (grupo, iconame, icon) values ('beer', 'Grados de Alcohol' , '029-alcohol.svg');
insert into icons (grupo, iconame, icon) values ('beer', 'Brindis' , '030-beer.svg');
insert into icons (grupo, iconame, icon) values ('beer', 'Naranjada' , '035-orange.svg');
insert into icons (grupo, iconame, icon) values ('beer', 'Cerveza 4' , '042-beer.svg');

/* Café */ 
insert into icons (grupo, iconame, icon) values ('coffee', 'Café' , '001-coffee.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Prensa' , '002-french press.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Café para Llevar' , '003-coffee cup.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Cafetera' , '008-coffee maker.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Molino' , '005-coffee grinder.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Sin Cafeína' , '006-no caffeine.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Bolsa de Café' , '007-coffee bag.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Pastel' , '009-cake.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Cafetera 2' , '010-coffee pot.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Cafetera 3' , '011-pot.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Café Semilla' , '013-bean.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Jarabe' , '014-syrup.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Helado' , '015-ice cream.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Frappe' , '016-frappe.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Canutillo' , '017-eclair.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Bolsa de Café' , '018-coffee bag.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Leche' , '019-milk.svg');
insert into icons (grupo, iconame, icon) values ('coffee', 'Galletas' , '020-cookie.svg');

/* Fast Food  */ 
insert into icons (grupo, iconame, icon) values ('delivery', 'Papas Fritas' , '001-french fries.svg');
insert into icons (grupo, iconame, icon) values ('delivery', 'Bolsa de Envío' , '002-food pack.svg');
insert into icons (grupo, iconame, icon) values ('delivery', 'Pizza' , '003-pizza.svg');
insert into icons (grupo, iconame, icon) values ('delivery', 'Comida China' , '004-rice.svg');
insert into icons (grupo, iconame, icon) values ('delivery', 'Hamburguesa' , '005-burger.svg');
insert into icons (grupo, iconame, icon) values ('delivery', 'Soda' , '006-Soft drink.svg');
insert into icons (grupo, iconame, icon) values ('delivery', 'Cubeta de Pollo' , '007-chicken bucket.svg');
insert into icons (grupo, iconame, icon) values ('delivery', 'Café' , '008-coffee cups.svg');
insert into icons (grupo, iconame, icon) values ('delivery', 'Dona' , '009-food delivery.svg');

/* Granja  */
insert into icons (grupo, iconame, icon) values ('farming', 'Trigo' , '001-wheat.svg');
insert into icons (grupo, iconame, icon) values ('farming', 'Zanahoria' , '002-carrots.svg');
insert into icons (grupo, iconame, icon) values ('farming', 'Huevos' , '003-eggs.svg');
insert into icons (grupo, iconame, icon) values ('farming', 'Miel' , '004-honey.svg');
insert into icons (grupo, iconame, icon) values ('farming', 'Tomate' , '005-tomato.svg');
insert into icons (grupo, iconame, icon) values ('farming', 'Semillas' , '006-seeds.svg');
insert into icons (grupo, iconame, icon) values ('farming', 'Cerdo' , '007-pig.svg');
insert into icons (grupo, iconame, icon) values ('farming', 'Canasta' , '008-basket.svg');
insert into icons (grupo, iconame, icon) values ('farming', 'Leche' , '009-milk.svg');
insert into icons (grupo, iconame, icon) values ('farming', 'Jamón' , '010-jam.svg');
insert into icons (grupo, iconame, icon) values ('farming', 'Queso' , '011-cheese.svg');
insert into icons (grupo, iconame, icon) values ('farming', 'Calabaza' , '012-pumpkin.svg');
insert into icons (grupo, iconame, icon) values ('farming', 'Maíz' , '015-corn.svg');

/* Gastronomia */
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Budín' , '001-pudding.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Crepe' , '002-crepe.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Queso' , '003-cheese.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Hot Dog' , '004-hot dog.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Sandwich' , '005-sandwich.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Pastel' , '006-cake.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Vino' , '007-wine.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Aceite de Oliva' , '008-olive oil.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Cubeta de Pollo' , '009-chicken leg.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Dim Sum' , '010-dim sum.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Takoyaki' , '011-takoyaki.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Prensa' , '012-french press.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Salsa' , '013-sauce.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Salteados' , '014-frying pan.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Barra de Chocolate' , '015-chocolate bar.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Pinchos' , '016-skewer.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Tostadora' , '017-toaster.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Tarta' , '018-tart.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Pizza' , '019-pizza.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Carne' , '020-steak.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Licor' , '021-liquor.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Ensalada' , '023-salad.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Cheesecake' , '027-cheesecake.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Nachos' , '028-nachos.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Taco' , '029-taco.svg');
insert into icons (grupo, iconame, icon) values ('gastronomy', 'Dona' , '030-donut.svg');

/* grocery */
insert into icons (grupo, iconame, icon) values ('grocery', '' , '');

/* Internacional */
insert into icons (grupo, iconame, icon) values ('international', 'Hot Dog' , '001-hot dog.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Pollo' , '001-hot dog.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Galletas' , '003-cookies.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Papas Fritas' , '004-french fries.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Costillas' , '005-ribs.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Comida China' , '009-noodles.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Onigiri' , '010-onigiri.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Tortilla' , '011-tortilla.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Burrito' , '012-burrito.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Ensalada' , '013-salad.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Guacamole' , '014-guacamole.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Croissant' , '015-croissant.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Comida India' , '016-indian food.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Pinchos' , '018-skewer.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Sandwich' , '019-sandwich.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Pancakes' , '020-pancakes.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Pescado' , '022-fish.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Dumplings' , '023-dumplings.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Arroz' , '024-rice.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Samosa' , '025-samosa.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Sushi' , '026-sushi roll.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Muffin' , '027-muffin.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Crepe' , '028-crepe.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Helado' , '029-ice cream.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Pan' , '030-bread.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Palomitas' , '033-popcorn.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Pollo' , '034-boiled.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Sopa' , '035-hot soup.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Pretzel' , '036-pretzel.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Hamburguesa' , '037-burger.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Waffle' , '038-waffle.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Cupcake' , '039-cupcake.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Taco' , '040-taco.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Carne' , '041-steak.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Omelette' , '042-omelette.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Ensalada' , '043-salad.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Pastel' , '044-cake.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Salchichas' , '045-sausages.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Donas' , '047-donut.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Nachos' , '049-nachos.svg');
insert into icons (grupo, iconame, icon) values ('international', 'Pizza' , '050-pizza.svg');

/* Tea */
insert into icons (grupo, iconame, icon) values ('tea', 'Frozen' , '001-bubble tea.svg');
insert into icons (grupo, iconame, icon) values ('tea', 'Té' , '002-tea.svg');
insert into icons (grupo, iconame, icon) values ('tea', 'Té Rojo' , '003-red tea.svg');
insert into icons (grupo, iconame, icon) values ('tea', 'Té de Limón' , '004-lemon tea.svg');
insert into icons (grupo, iconame, icon) values ('tea', 'Té Espumoso' , '006-bubble tea.svg');
insert into icons (grupo, iconame, icon) values ('tea', 'Té con Leche' , '007-mik tea.svg');
insert into icons (grupo, iconame, icon) values ('tea', 'Té Negro' , '008-black tea.svg');
insert into icons (grupo, iconame, icon) values ('tea', 'Té Verde' , '009-green tea.svg');

/* Vino */
insert into icons (grupo, iconame, icon) values ('wine', 'Barril' , '001-wine barrel.svg');
insert into icons (grupo, iconame, icon) values ('wine', 'Vino' , '004-wine bottle.svg');
insert into icons (grupo, iconame, icon) values ('wine', 'Balde de Vino' , '005-wine bucket.svg');
insert into icons (grupo, iconame, icon) values ('wine', 'Copa de Vino' , '010-wine glass.svg');
insert into icons (grupo, iconame, icon) values ('wine', 'Botella de Vino' , '012-wine bottle.svg');
insert into icons (grupo, iconame, icon) values ('wine', 'Vino y Queso' , '023-wine.svg');
insert into icons (grupo, iconame, icon) values ('wine', 'Uvas' , '025-grapes.svg');
insert into icons (grupo, iconame, icon) values ('wine', 'Vino en Pareja' , '027-wine glasses.svg');
insert into icons (grupo, iconame, icon) values ('wine', 'Vino y Comida' , '031-wine.svg');
insert into icons (grupo, iconame, icon) values ('wine', '' , '');

/* Antiguo */
insert into icons (grupo, iconame, icon) values ('antiguo', 'Máquina de Café' , '001-maquina-de-cafe.png');
insert into icons (grupo, iconame, icon) values ('antiguo', 'Té Verde' , '002-t-verde.png');
insert into icons (grupo, iconame, icon) values ('antiguo', 'Café' , '003-taza-de-caf.png');
insert into icons (grupo, iconame, icon) values ('antiguo', 'Taza de Café' , '004-taza-de-caf-1.png');
insert into icons (grupo, iconame, icon) values ('antiguo', 'Café para Llevar' , '005-taza-de-caf-2.png');
insert into icons (grupo, iconame, icon) values ('antiguo', 'Té Helado' , '006-t-helado.png');
insert into icons (grupo, iconame, icon) values ('antiguo', 'Tarta de Queso' , '007-tarta-de-queso.png');
insert into icons (grupo, iconame, icon) values ('antiguo', 'Canasta de Pan' , '008-panadera.png');
insert into icons (grupo, iconame, icon) values ('antiguo', 'Pretzel' , '009-galleta-salada.png');
insert into icons (grupo, iconame, icon) values ('antiguo', 'Cerveza' , 'cerveza.png');
insert into icons (grupo, iconame, icon) values ('antiguo', 'Evento' , 'evento.png');
insert into icons (grupo, iconame, icon) values ('antiguo', 'Mantequilla de Maní' , 'mantequilla-de-mani.png');
insert into icons (grupo, iconame, icon) values ('antiguo', 'Pizza' , 'pizza-slice.png');
insert into icons (grupo, iconame, icon) values ('antiguo', 'Sandwich' , 'sandwich.png');