<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## CLONARE UNA REPO DA GITHUB

CREARE LA NUOVA REPO
COPIARE IL LINK DAL DROPDOWN ***CODE*** DA GitHub
ESEGUIRE
```bash
git clone [LINK CLONAZIONE COPIATO] [NOME DIRECTORY DI DESTINAZIONE]
```
ES:
```bash
git clone https://github.com/francescomascellino/laravel-one-to-many.git laravel-many-to-many
```

ELIMINARE LA CARTELLA .git
```bash
rm -rf .git
```

INIZIALIZZARE E COMMITTARE
```bash
git init
git add .
git commit -m
```

COPIARE I COMANDI DI DA GITHUB PER AGGIUNGERE L'ORIGINE REMOTA E PUSHARE SU MAIN
```bash
git remote add origin https://github.com/francescomascellino/laravel-many-to-many.git
git branch -M main
git push -u origin main
```

INSTALLARE LE DIPENDENZE
```bash
composer install
```

RINOMINARE IL FILE COPIA DI .env ED EFFETTUARE LE MODIFICHE

(DATI DEL DATABASE, NOME APP, DISK SU public...)

GENERARE LA CHIAVE DELL'APP
```bash
php artisan key:generate
```

COLLEGARE LO STORAGE
```bash
php artisan storage:link
```

INSTALLARE I PACCHETTI
```bash
npm i
```

SE NECESSARIO CREARE LA CARTELLA DI SALVATAGGIO DEI FILES IN storage/app/public/[image disk folder]

MIGRARE LE VECCHIE TABELLE
```bash
php artisan migrate
```

PER SEEDARE LE VECCHIE TABELLE
```bash
php artisan db:seed --class=TypeSeeder

php artisan db:seed --class=ProjectSeeder
```

## MANY TO MANY RELATIONSHIP

CREARE MODELLO, MIGRATION E SEEDER
```bash
php artisan make:model Technology -ms // migration seeder
```

EDITARE LA MIGRATION DELLA NUOVA TABELLA ***technologies***
```php
public function up(): void
    {
        Schema::create('technologies', function (Blueprint $table) {
            $table->id();

            $table->string('name', 50)->unique;
            $table->string('slug', 50);

            $table->timestamps();
        });
    }
```

EDITARE IL SEEDER DELLA NUOVA TABELLA INSERENDO LE PRIME TECNOLOGIE
```php
public function run(): void
    {
        $technologies = ['CSS', 'Html', 'Javascript', 'Bootstrap', 'Vue.js', 'Vite', 'Php', 'MySQL', 'Laravel'];

        foreach ($technologies as $technology) {
            $newTechnology = new Technology();
            $newTechnology->name = $technology;
            $newTechnology->slug = Str::slug($newTechnology->name);
            $newTechnology->save();
        }

    }
```

CREARE LA MIGRAZIONE PER LA TABELLA PIVOT
❗**ATTENZIONE USARE L'ORDINE ALFABETICO NELLE TABELLE DA COLLEGARE**❗
```bash
php artisan make:migration create_project_technology_table
```

EDITARE LA MIGRATION DELLA NUOVA TABELLA ***project_technology***
```php
public function up(): void
    {
        Schema::create('project_technology', function (Blueprint $table) {
            $table->id();

            $table->foreign('project_id')
                ->references('id')
                ->on('projects');

            $table->foreign('technology_id')
                ->references('id')
                ->on('technologies');

            $table->primary(['project_id', 'technology_id']); // IMPEDISCE CHE SI POSSA ASSOCIARE DUE VOLTE LO STESSO PROGETTO E LA STESSA TECH (QUINDI EVITANDO PROGETTI CON DUE TECH UGUALI)

            $table->timestamps();
        });
    }
```

