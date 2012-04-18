ACM
=============
`ACM` is a Symfony 1.4 application to manage algae culture and strain
collections.

`ACM` has been developed following [Banco Español de Algas](http://bea.marinebiotechnology.org/)
requirements, but everyone is welcome to contribute with new additions.

Requirements
------------
* A database connection to store data (MySQL is strongly recommended).
* [ImageMagick](http://www.php.net/manual/en/book.imagick.php) PHP extension.
* [ImageMagick](http://www.imagemagick.org/) binaries.

Depending on the pictures you want to manage it may be necessary to adjust web
server upload parameters.

Installation
------------
After cloning the repository and configure the database connection
you have to run the following commands:

* `mkdir -p cache log web/uploads/tmp`
* `./symfony project:permissions`
* `git submodule init`
* `git submodule update`
* `./symfony doc:migrate`

Then you can create a superadmin user with:

`./symfony guard:create-user --is-super-admin <email> <username> <password>`

Distribution
------------
`ACM` is released under the GNU General Public License, version 3

Credits
-------
* Banco Español de Algas - [http://bea.marinebiotechnology.org/](http://bea.marinebiotechnology.org/)
* Singular Factory - [http://www.singularfactory.com/](http://www.singularfactory.com/)