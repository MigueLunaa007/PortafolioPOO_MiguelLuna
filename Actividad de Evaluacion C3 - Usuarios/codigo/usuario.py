import re

# clase base que representa a cualquier usuario del sistema
class Usuario:
    def __init__(self, nombre, email):
        self.nombre = nombre
        self.email =    self._validar_email(email)  # desafio: validacion de email

    # valida que el email tenga un formato correcto usando regex (regular expression)
    def _validar_email(self, email):
        patron = r'^[\w\.-]+@[\w\.-]+\.\w{2,}$'
        if re.match(patron, email):
            return email
        else:
            raise ValueError(f"Advertencia: Email invalido: '{email}'")

    # muestra los datos basicos del usuario
    def mostrar_datos(self):
        print(f"  Nombre : {self.nombre}")
        print(f"  Email  : {self.email}")

    # metodo que cada subclase debe sobrescribir
    def acceso_sistema(self):
        print(f"  [{self.nombre}] tiene acceso generico al sistema.")

    # desafio: saludo personalizado
    def saludar(self):
        print(f"  ¡Hola, {self.nombre}! Bienvenido al sistema.")