from usuario import Usuario

# clase cliente: hereda de usuario y agrega puntos de fidelidad
class Cliente(Usuario):
    def __init__(self, nombre, email, puntos=0):
        super().__init__(nombre, email)       # llama al constructor de usuario
        self.puntos = puntos                  # atributo propio de cliente

    # sobrescribe el metodo de la clase base
    def acceso_sistema(self):
        print(f"  [{self.nombre}] CLIENTE — Acceso a zona de compras. Puntos acumulados: {self.puntos}.")

    # muestra datos incluyendo los puntos
    def mostrar_datos(self):
        super().mostrar_datos()               # reutiliza mostrar_datos() de usuario
        print(f"  Puntos de fidelidad: {self.puntos}")