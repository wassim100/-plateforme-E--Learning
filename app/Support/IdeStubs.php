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
            public function newQuery() { return new Builder(); }
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
        class Schema { public static function create($t, $cb){} public static function dropIfExists($t){} }
    }
}

namespace Illuminate\Support {
    if (!class_exists(Str::class)) {
        class Str { public static function title($v){return $v;} public static function slug($v){return $v;} public static function random($l){return 'xxxx';} }
    }
}

namespace Illuminate\Database {
    if (!class_exists(Seeder::class)) {
    abstract class Seeder { public function run(){} }
    }
}
