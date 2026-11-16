<?php
enum Materiales: int {
    case Madera = 5;
    case Hierro = 10;
    case Contrachapado = 15;
    case Acero = 20;

    public function descripcion(): string {
        return match($this) {
            self::Madera => 'Madera',
            self::Hierro => 'Hierro',
            self::Contrachapado => 'Contrachapado',
            self::Acero => 'Acero',
        };
    }

   public function valor(): string {
        return match($this) {
            self::Madera => 5,
            self::Hierro => 10,
            self::Contrachapado => 15,
            self::Acero => 20,
        };
    }

   public static function casos(): array {
        return self::cases();
    }

}
