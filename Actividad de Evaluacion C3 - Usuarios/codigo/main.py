from usuario import Usuario
from admin import Admin
from cliente import Cliente
from invitado import Invitado

# desafio: mostrar la lista de usuarios
#  lista global de usuarios del sistema
# aplicacion principal: crear al menos 1 administrador, 1 cliente, 1 invitado
usuarios = [
    Admin("Lhya Hernandez", "lhya@admin.com", nivel_acceso=5),
    Cliente("María Rivera", "maria@cliente.com", puntos=320),
    Invitado("Miguel Sin Cuenta", "miguel@temp.com"),
]
 
#  funcion: mostrar todos los usuarios
def mostrar_todos():
    print("\n" + "="*45)
    print("        LISTA DE USUARIOS DEL SISTEMA")
    print("="*45)
    for u in usuarios:
        print(f"\n▶ Tipo: {type(u).__name__}")
        u.mostrar_datos()
        u.acceso_sistema()
    print("="*45)

#  desafio : polimorfismo — recorrer usuarios

def demo_polimorfismo():
    print("\n" + "="*45)
    print("       DEMOSTRACIÓN DE POLIMORFISMO")
    print("="*45)
    print("  Llamando a acceso_sistema() en cada objeto:")
    for u in usuarios: # misma llamada, comportamiento distinto segun el tipo real
        u.acceso_sistema() # admin, cliente o invitado responden diferente
 
#  funcion: agregar nuevo usuario al sistema

def agregar_usuario():
    print("\n── AGREGAR USUARIO ──")
    print("  1) Admin")
    print("  2) Cliente")
    print("  3) Invitado")
    tipo = input("  Tipo: ").strip()
 
    nombre = input("  Nombre: ").strip()
    email  = input("  Email: ").strip()
 
    try:
        if tipo == "1":
            nivel = int(input("  Nivel de acceso (1-5): ").strip())
            usuarios.append(Admin(nombre, email, nivel))
        elif tipo == "2":
            puntos = int(input("  Puntos iniciales: ").strip())
            usuarios.append(Cliente(nombre, email, puntos))
        elif tipo == "3":
            usuarios.append(Invitado(nombre, email))
        else:
            print("  Opcion invalida.")
            return
        print(f"  ✓ Usuario '{nombre}' agregado correctamente.")
    except ValueError as e:
        print(f"  ✗ Error: {e}")
 

#  funcion: saludar a todos

def saludar_todos():
    print("\n" + "="*45)
    print("              SALUDOS")
    print("="*45)
    for u in usuarios:
        u.saludar()
 
#  menu principal

def menu():
    while True:
        print("\n╔══════════════════════════════════╗")
        print("║   SISTEMA DE GESTION DE USUARIOS ║")
        print("╠══════════════════════════════════╣")
        print("║  1. Mostrar todos los usuarios   ║")
        print("║  2. Agregar nuevo usuario        ║")
        print("║  3. Demostracion polimorfismo    ║")
        print("║  4. Saludar a todos              ║")
        print("║  5. Salir                        ║")
        print("╚══════════════════════════════════╝")
        opcion = input("  Elige una opcion: ").strip()
 
        if opcion == "1":
            mostrar_todos()
        elif opcion == "2":
            agregar_usuario()
        elif opcion == "3":
            demo_polimorfismo()
        elif opcion == "4":
            saludar_todos()
        elif opcion == "5":
            print("\n  ¡Hasta luego!\n")
            break
        else:
            print("  Opcion no valida. Intenta de nuevo.")
 
#  volver al punto de entrada
if __name__ == "__main__":
    menu()