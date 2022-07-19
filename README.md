# Prueba tecnica Symfony - Adrián Manzano

Para desarollar esta prueba tecnica he partido de la base de este repositorio de GIT, donde puedes tener un entorno de symfony con docker más rapido.

[Repositorio base](https://github.com/dunglas/symfony-docker)

# Anotaciones

- **Actions**: Durante de los actions del Easy Admin he dado por hecho que los a los que no se les hace referencia, no están permitidos. He utilizado el metodo "disable" ya que es el más completo, no es solo una limitación visual como el "remove"

- **Load CSV**: Ya que el archivo que tenemos que cargar es muy extenso, lo ideal seria no utilizar PHP, se podria mirar de alguna opción para sacar este procesado a python por ejemplo que este lenguaje está mas preparado para tratar con gran cantidad de datos.
En mi caso he decido iterar todas las rows y a la vez ir insertando en base de datos los nuevos objetos, he utilizado el "Bulk insert" mediante "batches de 20", en la documentación de doctrine te recomiendan hacer este tipo de insertes cuando manejas con tantos datos. Igualmente este procesado tarda mucho.


