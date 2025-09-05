<?php
/**
 * Dev-only IDE stubs to calm static analyzers in editors.
 * These are wrapped with class/trait existence checks and won't override real framework classes.
 */

namespace Illuminate\Database\Eloquent {
    if (!class_exists(Builder::class)) {
        class Builder {
            public function where($column, $operator = null, $value = null) { return $this; }
            public function when($value, callable $callback) { $callback($this, $value); return $this; }
            public function orderByDesc($column) { return $this; }
            public function paginate($perPage = 15) { return $this; }
            public function withQueryString() { return $this; }
            public function count() { return 0; }
            public function __call($name, $arguments) { return $this; }
        }
    }
    if (!class_exists(Model::class)) {
        abstract class Model {
            /**
             * Pseudo primary key for analyzers.
             * @var int|null
             */
            public $id;

            public function newQuery() {
                // Return a lightweight fluent proxy to satisfy analyzers without invoking the real Builder constructor.
                return new class {
                    public function where($column, $operator = null, $value = null) { return $this; }
                    public function when($value, callable $callback) { $callback($this, $value); return $this; }
                    public function orderByDesc($column) { return $this; }
                    public function orderBy($column, $direction = 'asc') { return $this; }
                    public function paginate($perPage = 15) { return $this; }
                    public function withQueryString() { return $this; }
                    public function count() { return 0; }
            public function with($relations) { return $this; }
            public function withCount($relations) { return $this; }
            public function first() { return null; }
                    public function __call($name, $arguments) { return $this; }
                };
            }
            public static function query(){ return (new static())->newQuery(); }
            public function getKey(){ return $this->id ?? null; }
            public function getAttribute($key){ return $this->$key ?? null; }
            public function hasMany($related, $foreignKey = null, $localKey = null) { return $this; }
            public function belongsTo($related, $foreignKey = null, $ownerKey = null, $relation = null) { return $this; }
            public function belongsToMany($related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null, $parentKey = null, $relatedKey = null, $relation = null) { return $this; }
        public static function all() { return new \Illuminate\Support\Collection(); }
            public static function create(array $attributes = []) {
                $obj = new static();
                foreach ($attributes as $k => $v) { $obj->$k = $v; }
                if (!isset($obj->id)) { $obj->id = rand(1, 100000); }
                return $obj;
            }
            public static function firstOrCreate(array $attributes, array $values = []) {
                $obj = new static();
                foreach (array_merge($attributes, $values) as $k => $v) { $obj->$k = $v; }
                if (!isset($obj->id)) { $obj->id = rand(1, 100000); }
                return $obj;
            }
            public static function updateOrCreate(array $attributes, array $values = []) {
                $obj = new static();
                foreach (array_merge($attributes, $values) as $k => $v) { $obj->$k = $v; }
                if (!isset($obj->id)) { $obj->id = rand(1, 100000); }
                return $obj;
            }
            public function fill(array $attributes) { return $this; }
            public function save(array $options = []) { return true; }
            public function delete() { return true; }
            public static function factory(...$args) { return new class {
                public function count($n){ return $this; }
                public function create($attrs = []){ return []; }
            }; }
        }
    }
}

namespace Illuminate\Foundation\Auth {
    if (!class_exists(User::class)) {
        abstract class User extends \Illuminate\Database\Eloquent\Model {}
    }
}

namespace Illuminate\Database\Eloquent\Factories {
    if (!trait_exists(HasFactory::class)) {
        trait HasFactory {}
    }
}

namespace Illuminate\Http {
    if (!class_exists(Request::class)) {
        class Request {
            public function validate(array $rules) { return []; }
            public function get($key, $default = null) { return $default; }
            public function user() { return null; }
            public function only($keys) { return []; }
            public function except($keys) { return []; }
            public function hasFile($key) { return false; }
            public function file($key, $default = null) { return null; }
        }
    }
}

namespace Illuminate\Foundation\Http {
    if (!class_exists(FormRequest::class)) {
        abstract class FormRequest extends \Illuminate\Http\Request {
            public function validated() { return []; }
            public function rules() { return []; }
            public function authorize() { return true; }
            public function route($key = null, $default = null) { return $default; }
        }
    }
}

// Additional common Illuminate symbols used in database layer and helpers
namespace Illuminate\Database\Eloquent\Factories {
    if (!class_exists(Factory::class)) {
        abstract class Factory {
            /** @var \Faker\Generator */
            protected $faker;
            public function __construct() { $this->faker = \Faker\Factory::create(); }
            public static function new() { return new static(); }
            public static function factory(...$args) { return new class {
                public function count($n){ return $this; }
                public function create($attrs = []){ return []; }
            }; }
        }
    }
}

namespace Illuminate\Database\Migrations {
    if (!class_exists(Migration::class)) {
        abstract class Migration { public function up(){} public function down(){} }
    }
}

namespace Illuminate\Database\Schema {
    if (!class_exists(Blueprint::class)) {
        class Blueprint { public function __call($name,$args){ return $this; } }
    }
}

namespace Illuminate\Support\Facades {
    if (!class_exists(Schema::class)) {
        class Schema {
            public static function create($t, $cb){}
            public static function dropIfExists($t){}
            public static function table($t, $cb){}
            public static function hasColumn($table, $column){ return true; }
            public static function hasTable($table){ return true; }
        }
    }
    if (!class_exists(DB::class)) {
        class DB {
            public static function statement($sql){ return true; }
            public static function table($t){ return new class {
                public function updateOrInsert($keys, $values){ return true; }
                public function insertGetId($values){ return rand(1,1000); }
                public function insert($values){ return true; }
                public function delete(){ return true; }
            }; }
        }
    }
}

namespace Illuminate\Support {
    if (!class_exists(Str::class)) {
        class Str { public static function title($v){return $v;} public static function slug($v){return $v;} public static function random($l){return 'xxxx';} }
    }
    if (!class_exists(Collection::class)) {
        class Collection {
            public function count(){ return 0; }
            public function links(){ return ''; }
            public function __call($name, $arguments){ return $this; }
        }
    }
}

namespace Illuminate\Database {
    if (!class_exists(Seeder::class)) {
    abstract class Seeder { public function run(){} public function call($class, $silent = false){} }
    }
}

// Global helpers (simplified) for analyzers
namespace {
    if (!function_exists('view')) {
        function view($view = null, $data = []) { return '';
        }
    }
    if (!function_exists('collect')) {
        function collect($value = []) { return new \Illuminate\Support\Collection(); }
    }
    if (!function_exists('public_path')) {
        function public_path($path = '') { return __DIR__ . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : ''); }
    }
    // Global facade aliases stubs
    if (!class_exists('Schema')) {
        class Schema extends \Illuminate\Support\Facades\Schema {}
    }
    if (!class_exists('DB')) {
        class DB extends \Illuminate\Support\Facades\DB {}
    }
}

namespace Illuminate\Support\Facades {
    if (!class_exists(Hash::class)) {
        class Hash { public static function make($v){ return (string)$v; } }
    }
    if (!class_exists(Storage::class)) {
        class Storage {
            public static function disk($name){ return new class {
                public function put($path, $contents){ return true; }
                public function delete($path){ return true; }
                public function exists($path){ return true; }
            }; }
            public static function url($path){ return '/storage/' . ltrim($path, '/'); }
        }
    }
    if (!class_exists(View::class)) {
        class View {
            public static function make($view = null, $data = []) { return ''; }
        }
    }
    if (!class_exists(Redirect::class)) {
        class Redirect {
            public static function route($name, $params = []) { return new class {
                public function with($k,$v){ return $this; }
            }; }
        }
    }
}
