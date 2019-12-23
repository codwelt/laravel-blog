## Instalacion

Ejecutar en la consola dentro en la raiz del proyecto el comando: 
```bash
$ composer require codwelt/laravel-blog
```

o añadiendo directamente el el archivo `composer.json`


```json
{
    "require": {
        "codwelt/laravel-blog": "~1.0"
    }
    
}
```

Luego en el archivo `config/app.php` incluir el siguiente service provider

```php
'providers' => [
    Codwelt\Blog\BlogServiceProvider::class,
];
```

Puede añadir en su archivo composer.json en script el evento post-update-cmd y endonde puede añadir el comando update del post para que se ejecute cada vez que se actualicen los paquetes.
```json
     "post-update-cmd":[
                "@php artisan codwelt_blog:update"
     ]
```

Ejecutar dentro del proyecto el comando 

```bash
$ php artisan codwelt_blog:install
```



## Configuracion

### Creadores de post
Para que se puedan crear los post es necesario asociarlos a un modelo que seria el autor del post, por tal motivo es necesario indicar cual es el modelo de su proyecto quien creara los post.
Para ello en el el archivo llamado `blogCodwelt.php` en la ruta `config/blogCodwelt.php` estara un array como este

```php
  'creatorPost' => [
        'model' => App\User::class,
        'columnOfRelation' => 'id'
    ],
```
en el key llamado `model` por defecto esta la ruta del modelo usuario pero si este no sera en su proyecto el modelo que creara los post reemplaze el de usuario y escriba la ruta de la clase del modelo recuerde que debe terminar en `::class`. 
El  key llamado `columnOfRelation` debe indicar la columna con la cual se relacionara los post con el modelo; por defecto es el id de la tabla que es la llave primaria de la tabla usuarios, asi que si su modelo en la tabla tiene una llave primaria diferente debe cambiarla.

Para finalizar en su modelo creados de post debe usar el trait llamado `CreatorOfPosts` que su ruta seria `CodWelt\Blog\Operations\Core\Traits\CreatorOfPosts`. 
Adicionalmente el trait tiene un metodo abstracto llamado `getName` el cual debe implentar en el modelo y el cual debe retornar el nombre que se mostrara para 
el creador del post, que para nuestro caso representa el mismo fillable `name` del modelo

```
   <?php
   
   namespace App;
   
   use Codwelt\Blog\Operations\Core\Traits\CreatorOfPosts;
   use Illuminate\Foundation\Auth\User as Authenticatable;
   
   class User extends Authenticatable
   {
       use CreatorOfPosts;
   
  
    
        
       /**
        * The attributes that are mass assignable.
        *
        * @var array
       */
       protected $fillable = ['id', 'name', 'email', 'password', 'cargo', 'imgperfil', 'telefono', 'emailsecundario', 'activo'];
            
       /**
        * Debe retornar el nombre de quien crea el post
        * @return string
        */
       public function getName()
       {
           return $this->name;
       }
   }

```

