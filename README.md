
### Marvision PHP Framework 
![logo](http://s21.postimg.org/femk919yr/logo1.png) 

##### What is Marvision Framework ?

Marvision is a PHP web framework. It is written with speed and
flexibility in mind. It allows developers to build better and easy to maintain
websites with PHP.

this frame work can be used to develop all type of websites, from your personal blog
to high traffic websites .

##### Installation 

```git
$git clone https://github.com/marvision-framework/beta marvision
```
then go to : app/config/parameters.yml
and add your web site setting for localhost if working in localhost or the parameters of your official host like :

```yml
parameters_host:
    db_host: #database host here
    db_name: #db name 
    db_user: #db user id
    db_password: #db pass
```
next go to : web/model/

and create your database model ...
###### for example :

```git
touch Post.php
```
Note: The first letter is lowercase

add your validation function:
```php
<?php
	class Post extends Model
	{
##### validation of post (example)
		var $validate = array(
			'slug' => array(
				'rule' => '([a-z0-9\-]+)',
				'message' => "L'url n'est pas valide"
					)
			);	
				.....
```
add your database table content :
```php 
				.....
# @ posts.id is default 
# @ posts.slug 
#########################
	"slug" 	=> array(
		"type" 	=> "VARCHAR",
		"size" 	=> "20" 
	),
# @ posts.title
#########################
	"title" => array(
		"type" 	=> "VARCHAR" 
	),
				.....
```
and now you go to create your controller : web/controller/ 
###### for example :
```git
touch PagesController.php
```
```php
class PagesController extends Controller
	{
		....
	}
```
###### example of home page :
```php
function home(){
	$this->layout = 'default'; ///your layout used in this page
	$d['thisongl'] = 'home';  ///page title
	$this->loadModel('Post'); /// the model loadet inthis page

	$this->set($d);  ///send to view
}
```

and next step go to create your layout or page template : web/view/layout/

like : web/view/layout/default.php
```php
<?php echo $this->Session->flash(); ?>
<?php echo $content_for_layout; ?>
```
use HTML,CSS and Javascrip,....

finally go to create your page view : web/view/

like : /web/view/pages/home.php
 ```html
<h1>Home page</h1>
```
and we can use routing system : app/config/routing.php
 ```php
Router::connect('','pages/home');//home page 
```
##### Documentation 

The "[Quick Tour][1]" tutorial gives you a first feeling of the framework. If,
like us, you think that Marvision can help speed up your development and take
the quality of your work to the next level, read the official
[Marvision documentation][2].

##### Contributing 

Marvision is an open source, community-driven project.

and this just the beta for testing version

[1]: http://marwenhlaoui.com/
[2]: http://marwenhlaoui.com/
