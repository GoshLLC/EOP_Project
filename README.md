<h1>Gosh LLC-Eastern Oregon Pets</h1>

<p>1. Install XAMPP (can be found in artifact folder in OneDrive, or downloaded from source). Use the deafault installtion path C:\xampp\ (default).</p>
<p>2. Launch XAMPP Control Panel, click "Start" on Apache and MySQL.</p>
<p>3. Download all project files from GitHub.</p>
<p>4. Visit http:/localhost/phpmyadmin on browser of choice.</p>
<p>5. Create a database (if it doesn’t exist) named "Eastern_Oregon_Pets". Import animals.sql into phpMyAdmin.</p>
<p>6. Install Composer. Installer can be found on group OneDrive in artifacts folder. Make sure to select C:\xampp\htdocs as the path when prompted.</p>
<p>7. Install Laravel with the following command: composer create-project --prefer-dist laravel/laravel laravel-login-system</p>
<p>8. Import laravel_login_system.sql into database.</p>
<p>9. Rename .env.example to .env.</p>
<p>10. Generate and app key for .env with this command: 'php artisan key:generate'.</p>
<p>11. Laravel will automatically cop the key into the .env file in 'APP_KEY=' section..</p>

<p>Guide used for Laravel Login System: https://codeshack.io/login-system-laravel/</p>