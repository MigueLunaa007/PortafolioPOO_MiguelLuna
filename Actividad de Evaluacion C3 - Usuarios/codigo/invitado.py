from usuario import Usuario

# clase invitado: hereda de usuario con acceso limitado
class Invitado(Usuario):
    def __init__(self, nombre, email):
        super().__init__(nombre, email) #llama al constructor de usuario

    # sobrescribe el metodo con permisos restringidos
    def acceso_sistema(self):
        print(f"  [{self.nombre}] INVITADO — Solo puede ver contenido publico. Acceso limitado.")