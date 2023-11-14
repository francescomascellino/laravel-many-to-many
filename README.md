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
git clone https://github.com/francescomascellino/laravel-auth.git laravel-one-to-many
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
git remote add origin https://github.com/francescomascellino/laravel-one-to-many.git
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

## TABLE RELATIONS

CREATE THE NEW MODEL AND ITS MIGRATION

```bash
php artisan make:model Type

```
```bash
php artisan make:migration create_types_table
```

EDIT THE UP METHOD ON THE MIGRATION
```php
public function up(): void
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }
```

MIGRARE LA TABELLA NEL DATABASE

```bash
php artisan migrate
```

CREATE A SEEDER FOR THE NEW MODEL

```bash
php artisan make:seeder TypeSeeder
```
EDIT THE SEEDER

```php
$types = ['Fullstack', 'Frontend', 'Backend', 'API'];

foreach ($types as $type) {
    $new_type = new Type;
    $new_type->name = $type;
    $new_type->slug = Str::slug($new_type->name, '-');
    $new_type->save();
}
```

ESEGUIRE IL SEEDING

```bash
php artisan db:seed --class=TypeSeeder
```

CREARE UNA MIGRATION PER AGGIUNGERE LA COLONNA CON LA FOREIGN KEY ALLA TABELLA E AL MODELLO PROJECTS

```bash
php artisan make:migration add_type_id_foreign_key_to_projects_table
```

EDITARE I METODI UP E DOWN DELLA MIGRAZIONE APPENA CREATA

```php
public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // AGGIUNGE L'ID DI TYPE DOPO LA COLONNA ID
            $table->unsignedBiginteger('type_id')->nullable()->after('id');

            $table->foreign('type_id') // ASSEGNA LA FK type_id legata al TYPE
                ->references('id') // LEGATA AL CAMPO id
                ->on('types'); // DELLA TABELLA types
        });
    }
```

```php
public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('projects_type_id_foreign'); // ELIMINA LA FK type_id DALLA TABELLA projects
            $table->dropColumn('type_id'); // ELIMINA LA COLONNA type_id
        });
    }
```

ASSEGNARE LE RELAZIONI AI MODELLI

1 TYPE -> MANY PROJECTS
MODEL Type

```php
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Project;
```

```php

public function projects(): HasMany
    {
        return $this->hasMany(Project::class); // THIS TYPE HAS MANY PROJECTS
    }
```

OGNI PROJECT -> 1 TYPE
MODEL Project

```php
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Type;
```

```php
public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class); // THIS PROJECT BELONGS TO A TYPE
    }
```

ESEGUIRE LA MIGRAZIONE
```bash
php artisan migrate
```

PER ESEGUIRE IL SEEDING E ASSEGNARE UN VALORE RANDOM TRA GLI ID DI ***types*** USARE IL METODO ***pluck()***

IN ProjectSeeder.php
```php
$types = Type::pluck('id');
```
E CON FAKER PRENDERE UN VALORE CASUALE 
```php
$project->type_id = $faker->randomElement($types);
```

AGGIUNGERE LA SCELTA DEI TYPES ALLA CREAZIONE DI UN NUOVO PROGETTO:

AGGIUNGERE AL MODELLO ***Project*** IL CAMPO AI FILLABLE
```php
protected $fillable = ['type_id', 'title', 'slug', 'thumb', 'description', 'tech', 'github', 'link'];
```

AGGIUNGERE IN ***StoreProjectRequest*** IL CAMPO ***type_id***

exists:table,column
The field under validation must exist in a given database table.

```php
'type_id' => ['nullable', 'exists:types,id'],
```

ProjectController ***create()*** METHOD
```php
public function create()
    {
        $page_title = 'Add New';
        $types = Type::all();
        return view('admin.projects.create', compact('page_title', 'types'));
    }
```

***admin.projects.create*** VIEW:
```php
<label for="type_id" class="form-label">Type</label>
    <select class="form-select form-select 
    @error('type_id') is-invalid @enderror"
    name="type_id" id="type_id">
        <option selected>Select a Type</option>
        <option value="">Uncategorized</option>
            @foreach ($types as $type)
                <option value="{{$type->id}}"

                /* SE VI E' UN ERRORE E LA PAGINA VIENE RICARICATA IL CAMPO PRECEDENTEMENTE SELEZIONATO RESTA selected */
                {{ $type->id == old('type_id') ? 'selected' : '' }}>
                    {{$type->name}}
                </option>
            @endforeach
    </select>
```

AGGIUNGERE Types AL FORM DI EDIT:

AGGIUNGERE IN ***UpdateProjectREquest*** IL CAMPO ***type_id***
```php
'type_id' => ['nullable', 'exists:types,id'],
```

ProjectController ***edit()*** METHOD:
```php
public function edit(Project $project)
    {
        $page_title = 'Edit';

        $types = Type::all();
        return view('admin.projects.edit', compact('project', 'page_title', 'types'));
    }
```

***admin.projects.edit*** VIEW:
```php

<select class="form-select form-select @error('type_id') is-invalid @enderror" name="type_id" id="type_id">
    <option selected>Select a Type</option>
    <option value="">Uncategorized</option>

        @foreach ($types as $type)
            <option value="{{ $type->id }}" 
            {{-- SE VI E' UN ERRORE E LA PAGINA VIENE RICARICATA IL CAMPO PRECEDENTEMENTE SELEZIONATO RESTA selected --}}
            {{ $type->id == old('type_id', $project->type_id) ? 'selected' : '' }}>
                {{ $type->name }}
            </option>

        @endforeach
</select>
```

ADDING TYPE TO PROJECT ***show()***  VIEW

***admin.projects.show*** VIEW:
```php
<p><strong>Type: </strong>{{$project-type?->name}}</p>
```

OPPURE:
```php
<p><strong>Type: </strong>{{$project->type->name ? $project->type->name : 'Uncategorized'}}</p>
```

# EXTRA
## ASSOCIARE POST A USER
User -> Many Projects

Project -> one User. Project ha una FK legata all'User

PRIMA CREARE RELATION

Model post aggiungere la FK

```php
$fillable = [... 'category_id', 'user_id'];
```

PostController
MEDOTO store()
```php
$val_data['user_id'] = Auth::id()->orderbyDesc('id');
```

nel destroy() per evitare che altri elimino post non loro
```php
if($post->user_id === Auth::id()) {
    rules here
}
abort(403, 'NON PUOI');
```

index()
```php
$posts = Post::where('user_id', Auth::id())->orderByDesc('id')->paginate(12);
```

IMPEDIRE REGISTRAZONE E ROTTE AI NON LOGGATI

resources/routes/auth.php
```php
// 👇 COMMENTANDO QUESTE DUE ROTTE NON SARA' POSSIBILE REGISTRARSI ULTERIORMENTE
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);
```
1 -> 1

model user
```php
public function userDetail () {
    return hasOne(User_Detail::class)
}
```

model User_detail
```php
public function user () {
    return $this->belongsTo(User::class)
}
```

1 -> *

model user
```php
pubic function posts(){
    return $this_>hasMany(Posts::class)
}
```

model post
```php
pubic function user(){
    return $this_>belongsTo(User::class)
}
```

USEFUL COMMANDS TO REMEMBER:
```bash
php artisan migrate:refresh

artisan db:seed --class=TypeSeeder

php artisan db:seed --class=ProjectSeeder
```