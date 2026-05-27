from usuario import Usuario

# clase Admin: hereda de usuario y agrega nivel de acceso
class Admin(Usuario):
    def __init__(self, nombre, email, nivel_acceso):
        super().__init__(nombre, email)       # llama al constructor de usuario
        self.nivel_acceso = nivel_acceso      # atributo propio de admin

    # sobrescribe el metodo de la clase base
    def acceso_sistema(self):
        print(f"  [{self.nombre}] ADMINISTRADOR — Nivel {self.nivel_acceso}: acceso total al sistema.")

    # muestra datos incluyendo el atributo propio
    def mostrar_datos(self):
        super().mostrar_datos()               # reutiliza mostrar_datos() de usuario
        print(f"  Nivel de acceso: {self.nivel_acceso}")