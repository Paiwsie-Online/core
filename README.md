<p align="center">
    <h1 align="center">SmartAdmin Core<br><small>SmartAdmin platform</small></h1>
    <br>
</p>

When you have downlaoded the project, and created an empty params.php file you can run:<br>
<code>php yii migrate</code><br>
in your root folder to create necessary database tables to run the app.

<h3>Setting up a new instance</h3>
In order to customize the params you can create the file /config/param.php.<br>Use this in order to change where logo images are fetched from, application name etc.

<h3>Web aplication needs write permissions on:</h3>
/runtime<br>
/web/assets<br>
/web/uploads

<h3>Known required php extensions added after the fact on a server</h3>
<code>php_fileinfo.dll</code> (error noticed when importing language files)<br>