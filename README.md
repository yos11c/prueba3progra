# Servicio Mecánico Andrés 
Página web para el manejo de un inventario junto a un sistema de ventas para el taller Servicio Mecánico Andrés.

### Descripción
Este programa está dirigido principalmente para manejar un sistema de ventas e inventario para el área de un servicio mecánico, donde el sistema de ventas se divide en dos secciones: ventas y servicios, y el inventario se divide en varias secciones las cuales se mencionarán más adelante. El sistema se enfoca en que el usuario que lo utilice pueda llevar un mejor control de su negocio mediante una base de datos, donde se guarda la información a la cual puede acceder mediante la página en cualquier momento para realizar diferentes acciones.

### Instalación
Se debe de tener un programa que pueda realizar servidores locales (recomendable laragon, ya que, se utilizó el framework laravel), y una base de de datos llamada "prueba", junto a todas las tablas que contiene.

### Uso
Para poder usar está página web, el administrador debe de crearte una cuenta.
Si ya se tiene una cuenta, entonces, puede utilizarla.
Siendo un usuario de tipo gerente, sólo se es capaz de usar una cierta parte de la página web, la cual es, la sección de inventario, y la de empleados.

Al ingresar con una cuenta a la página, lo primero que se puede ver, es un fondo de madera (puede ser que haya algunas notas, pero, eso se explicará más adelante), y arriba, una barra de navegación, para poder elegir a que sección ir.

En la sección de inventario, se puede visualizar cinco apartados:
1. Motores
2. Transmisiones
3. Autopartes
4. Herramientas
5. Cajas de Herramientas

En cada uno, se puede visualizar una tabla, donde se mostrará información de dicha sección. En la esquina superior derecha de la tabla, se podrá ver un cuadro de texto, este cuadro de texto sirve para poder realizar una búsqueda en la tabla. Arriba de dicho cuadro de texto, aparecerá un botón, que al presionar, se abrirá un pequeño cuadro, donde se mostrará el formulario que debe de llenarse para poder ingresar un nuevo elemento.

Entrando a la página como un administrador. Aparecerá en la barra de navegación una nueva sección, llamada **Ganancias**, que, al presionar, se desplegará un menú, donde saldrán dos apartados:  
1. Servicios
2. Ventas

En cada uno, se mostrará lo mismo, una tabla que mostrará la información de dicha sección.

La parte de notas que se mencionó antes, en realidad, son avisos que se le mostrarán a los gerentes y al dministrador, donde, vendrá información sobre posibles próximas citas que se vayan a tener con los clientes. La tarea de los avisos, son que, recuerden al usuario que tiene que agendar una cita con el cliente.

### Manual de Usuario
##### Sistema de Ventas

El sistema de ventas sólo lo puede ver el administrador.
Este sistema se divide en dos apartados, en servicios y en ventas.

En el apartado de servicios, se puede visualizar una tabla, donde se mostrará la información que contiene. En la esquina superior derecha, se podrá ver un cuadro de texto, este cuadro de texto sirve para poder realizar una búsqueda en la tabla.
rriba de dicho cuadro de texto, aparecerá un botón, que al presionar, se abrirá un pequeño cuadro, donde se mostrará el formulario que debe de llenarse para poder ingresar un nuevo elemento.

Se debe escribir en cada uno de los formularios información requerida. Al llenar todos, se dederá de presionar el botón de agregar que viene al fondo del cuadro que salió para poder almacenar la información.

Mientras haya información en la tabla, al final de cada fila, se mostrarán dos botones, el que tiene forma de lápiz funciona para poder editar la información de dicha tabla. Funciona igual que la acción de agregar, al hablar de cambiar la información. El icono del bote de basura funciona para eliminar la fila en la que se encuentra.

El apartado de ventas funciona igual, sólo que, al agregar una venta, se mostrarán tres listas, una de motores, una de transmisiones y otra de autopartes. Se tiene que seleccionar una de ellas, y en cada una, se mostrará todos los productos que tiene la sección que se eligió. 

##### Inventario
El sistema de inventario funciona igual que el sistema de ventas. Esta sección puede ser vista por el administrador y el gerente. 

En la sección de inventario, se puede visualizar cinco apartados:
1. Motores
2. Transmisiones
3. Autopartes
4. Herramientas
5. Cajas de Herramientas

En cada uno, se puede visualizar una tabla, donde se mostrará información de dicha sección. En la esquina superior derecha de la tabla, se podrá ver un cuadro de texto, este cuadro de texto sirve para poder realizar una búsqueda en la tabla. Arriba de dicho cuadro de texto, aparecerá un botón, que al presionar, se abrirá un pequeño cuadro, donde se mostrará el formulario que debe de llenarse para poder ingresar un nuevo elemento.

##### Notificaciones
La sección de notificaciones es una sección que aparece en la página de inicio. Donde se mostrará una notificación para recordar que se debe de agendar una cita con algún cliente. En la notificación saldrán los siguientes datos:
1. Nombre del cliente
2. Apellido dle cliente
3. Teléfono del cliente
4. Servicio que se realizo
5. Fecha estimada para próxima cita
6. Descripción del servicio que se realizó

La condición para que aparezca una notificación, es que, la fecha que se espera sea la siguiente fecha, sea de una semana de diferencia con la fecha actual.

##### Niveles de usuario

Los diferentes niveles de usuario que hay son:
1. Administrador
2. Gerente

El administrador puede manejar toda la página web, y ver lo que el gerente no puede ver, como, la sección de ventas y la de Administrar Gerentes, en dónde, se puede agregar a un gerente, igual que en cualquier otra sección.

El gerente sólo puede ver la sección de inventario, la sección de empleados, y las notificaciones para recordar que se debe de agendar una cita con el cliente de la notificación.

##### Administración de Personal

La administración del Personal funciona igual que todas las demás secciones. Se puede agregar a un nuevo empleado, editar su información, y poder eliminarlo de la tabla.
