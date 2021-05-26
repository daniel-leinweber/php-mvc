# PHP MVC
This is a simple PHP MVC template. 

## Motivation
Since I am used to MVC when creating web applications with C# .NET, I was searching for a similar structure for my PHP projects.
I found the Udemy Course [Write PHP like a pro: build an MVC framework from scratch](https://davehollingworth.net/phpmvcg) by Dave Hollingworth and
started to build this template alongside the course.

## Technologies used
- PHP
- HTML
- mysqli
- Composer
- Twig

## How to use

### 1. Create a new project from the template

```
projectName = 'your-project-name';
git clone https://github.com/daniel-leinweber/php-mvc.git $projectName; 
cd $projectName; 
rm -r -f .git; 
git init; 
git add .; 
git commit -m 'Project created';
```

**Tip:** You can create a git alias to execute the above steps.

```
new = "!f() { template=${1}; projectName=${2}; if [ ! -z "$template" ] && [ ! -z "$projectName" ]; then git clone $template $projectName; cd $projectName; rm -r -f .git; git init; git add .; git commit -m 'Project created'; else echo "Please provide a template and a project name"; fi }; f"
```

The alias can then be used as follows:

```
git new https://github.com/daniel-leinweber/php-mvc.git your-project-name
```

### 2. Run **composer update** to install the project dependencies

This command will install twig, w3css, font-awesome and jquery. All files will be copied from the vendor folder into the [public/assets](public/assets/) folder.
The base template ([App/Views/base.html](App/Views/base.html)) will already include the frontend libraries.

### 3. Configure the **[public](public/)** folder as the root for your web server

### 4. Add your database and site configuration in the **[App/Config.php](App/Config.php)** file

### 5. Create Controllers, Views and Models as needed under the **[App](App/)** folder

### 6. Add additional routes in the **[Front-Controller (index.php)](public/index.php)** if neccessary
