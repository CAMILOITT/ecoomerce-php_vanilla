
import mysql.connector
from faker import Faker
import random
import datetime
import argparse

DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',
    'password': 'mysql@DEV1',
    'database': 'ecommerce'
}

NUM_USERS = 50         
NUM_CUSTOMERS = 1000   
NUM_PROVIDERS = 100
NUM_PRODUCTS = 500
NUM_SALES = 2000       
MINIMARKET_CATEGORIES = [
    'Bebidas', 'Lácteos y Refrigerados', 'Abarrotes', 'Snacks y Dulces',
    'Frutas y Verduras', 'Panadería', 'Cuidado Personal', 'Limpieza del Hogar'
]

MINIMARKET_PRODUCTS = {
    'Bebidas': ['Agua Mineral sin Gas 1.5L', 'Gaseosa Cola 2L', 'Jugo de Naranja 1L', 'Bebida Energética 473ml', 'Té Helado de Limón 500ml'],
    'Lácteos y Refrigerados': ['Leche Entera Larga Vida 1L', 'Yogur de Fresa 125g', 'Queso Fresco 250g', 'Mantequilla con Sal 200g', 'Huevos (docena)'],
    'Abarrotes': ['Arroz Blanco 1kg', 'Fideos 400g', 'Aceite de Girasol 900ml', 'Azúcar Blanca 1kg', 'Sal de Mesa 500g', 'Atún en Aceite 170g', 'Café Instantáneo 100g'],
    'Snacks y Dulces': ['Papas Fritas 150g', 'Galletas de Chocolate (paquete)', 'Barra de Chocolate 100g', 'Caramelos de Menta', 'Maní Salado 200g'],
    'Frutas y Verduras': ['Manzanas (kg)', 'Bananas (kg)', 'Tomates (kg)', 'Cebollas (kg)', 'Lechuga'],
    'Panadería': ['Pan de Molde Blanco', 'Pan Francés (unidad)', 'Medialunas (docena)'],
    'Cuidado Personal': ['Jabón de Tocador', 'Shampoo 2 en 1 400ml', 'Pasta Dental 90g', 'Papel Higiénico (x4 rollos)'],
    'Limpieza del Hogar': ['Detergente para Platos 500ml', 'Limpiador Multiuso 1L', 'Lavandina 1L', 'Bolsas de Basura (x10)']
}


fake = Faker('es_ES')

def create_connection():
    """Crea y devuelve una conexión a la base de datos."""
    try:
        conn = mysql.connector.connect(**DB_CONFIG)
        print("Conexión a la base de datos establecida con éxito.")
        return conn
    except mysql.connector.Error as err:
        print(f"Error al conectar a la base de datos: {err}")
        return None

def insert_data(conn, query, data):
    """Ejecuta una consulta de inserción masiva."""
    cursor = conn.cursor()
    try:
        cursor.executemany(query, data)
        conn.commit()
        print(f"{cursor.rowcount} registros insertados en la tabla.")
    except mysql.connector.Error as err:
        print(f"Error al insertar datos: {err}")
        conn.rollback()
    finally:
        cursor.close()

def get_ids(conn, table_name):
    """Obtiene todos los IDs de una tabla."""
    cursor = conn.cursor()
    cursor.execute(f"SELECT id FROM {table_name}")
    ids = [item[0] for item in cursor.fetchall()]
    cursor.close()
    return ids

def populate_base_data(conn):
    """Puebla las tablas base que no son transaccionales (usuarios, productos, etc.)."""
    print("\n--- Poblando tablas base ---")

    print("\n--- Poblando tabla 'documents' ---")
    documents_data = [('Cédula', 1), ('RUC', 1), ('Pasaporte', 1)]
    insert_data(conn, "INSERT INTO documents (name, state) VALUES (%s, %s)", documents_data)
    
    print("\n--- Poblando tabla 'roles' ---")
    roles_data = [('Gerente', 1), ('Cajero', 1), ('Reponedor', 1)]
    insert_data(conn, "INSERT INTO roles (name, state) VALUES (%s, %s)", roles_data)

    print(f"\n--- Poblando tabla 'users' con {NUM_USERS} trabajadores ---")
    document_ids = get_ids(conn, 'documents')
    role_ids = get_ids(conn, 'roles')
    users_data = []
    for _ in range(NUM_USERS):
        users_data.append((
            random.choice(role_ids),
            random.choice(document_ids),
            fake.first_name(), fake.last_name(), fake.numerify(text='############'),
            fake.address(), fake.numerify(text='##########'), fake.email(),
            fake.password(), 1, fake.date_time_this_decade(), fake.date_time_this_decade()
        ))
    insert_data(conn, "INSERT INTO users (role_id, document_id, name, lastname, dni, address, phone, email, password, state, created_at, updated_at) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", users_data)

    print(f"\n--- Poblando tabla 'customers' con {NUM_CUSTOMERS} clientes ---")
    customers_data = []
    for _ in range(NUM_CUSTOMERS):
        customers_data.append((
            random.choice(document_ids),
            fake.first_name(), fake.last_name(), fake.numerify(text='############'),
            fake.address(), fake.numerify(text='##########'), fake.email(),
            fake.password(), 1, fake.date_time_this_year(), fake.date_time_this_year()
        ))
    insert_data(conn, "INSERT INTO customers (document_id, name, lastname, dni, address, phone, email, password, state, created_at, updated_at) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", customers_data)

    print(f"\n--- Poblando tabla 'providers' con {NUM_PROVIDERS} registros ---")
    providers_data = []
    for _ in range(NUM_PROVIDERS):
        providers_data.append((
            fake.company(), fake.numerify(text='#############'), fake.address(),
            fake.numerify(text='##########'), fake.email(), fake.name(), 1
        ))
    insert_data(conn, "INSERT INTO providers (name, ruc, address, phone, email, consultant, state) VALUES (%s, %s, %s, %s, %s, %s, %s)", providers_data)

    print("\n--- Poblando tabla 'categories' con categorías de minimarket ---")
    categories_data = [(None, name, 1) for name in MINIMARKET_CATEGORIES]
    insert_data(conn, "INSERT INTO categories (parent_id, name, state) VALUES (%s, %s, %s)", categories_data)
    
    print(f"\n--- Poblando tabla 'products' con {NUM_PRODUCTS} productos de minimarket ---")
    cursor = conn.cursor()
    cursor.execute("SELECT id, name FROM categories")
    category_info = {name: id for id, name in cursor}
    cursor.close()
    products_data = []
    for _ in range(NUM_PRODUCTS):
        category_name = random.choice(list(MINIMARKET_PRODUCTS.keys()))
        product_name = random.choice(MINIMARKET_PRODUCTS[category_name])
        category_id = category_info[category_name]
        price = round(random.uniform(0.5, 50.0), 2)
        products_data.append((
            category_id, product_name, fake.ean(length=13), f"Descripción para {product_name}",
            random.choice([0, 1]), price, round(random.uniform(0.0, 0.10), 4),
            1, fake.date_time_this_year(), fake.date_time_this_year()
        ))
    insert_data(conn, "INSERT INTO products (category_id, name, code, description, iva, unit_price, discount, state, created_at, updated_at) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", products_data)

def populate_sales(conn):
    """Puebla únicamente las tablas de ventas y detalles de venta."""
    print(f"\n--- Poblando tablas 'sales' y 'sale_details' con {NUM_SALES} nuevas ventas ---")

    user_ids = get_ids(conn, 'users')
    customer_ids = get_ids(conn, 'customers')
    cursor = conn.cursor()
    cursor.execute("SELECT id, unit_price FROM products")
    product_info_list = cursor.fetchall()
    product_ids = [item[0] for item in product_info_list]
    product_prices = {item[0]: item[1] for item in product_info_list}
    cursor.close()

    if not user_ids or not customer_ids or not product_ids:
        print("\nError: No se pueden crear ventas.")
        print("Asegúrate de que las tablas 'users', 'customers' y 'products' contengan datos.")
        print("Ejecuta el script sin flags para poblar todas las tablas primero.")
        return

    for i in range(NUM_SALES):
        cursor = conn.cursor()
        try:
            sale_user_id = random.choice(user_ids)
            sale_customer_id = random.choice(customer_ids)
            bill_date = fake.date_time_between(start_date='-2y', end_date='now')
            
            sale_query = "INSERT INTO sales (user_id, customer_id, subtotal, tax, total, state, bill_number, bill_date, created_at, updated_at) VALUES (%s, %s, 0, 0, 0, 1, %s, %s, %s, %s)"
            bill_number = fake.numerify("FAC-####-#####")
            cursor.execute(sale_query, (sale_user_id, sale_customer_id, bill_number, bill_date, bill_date, bill_date))
            sale_id = cursor.lastrowid
            
            num_details = random.randint(1, 8)
            total_subtotal = 0
            total_tax = 0
            
            for _ in range(num_details):
                product_id = random.choice(product_ids)
                amount = random.randint(1, 5)
                price = product_prices[product_id]
                subtotal = amount * float(price)
                iva = subtotal * 0.12 # Asumiendo 12% IVA
                total = subtotal + iva
                
                detail_query = "INSERT INTO sale_details (sale_id, product_id, amount, price, discount, iva, subtotal, total) VALUES (%s, %s, %s, %s, 0, %s, %s, %s)"
                cursor.execute(detail_query, (sale_id, product_id, amount, price, iva, subtotal, total))
                
                total_subtotal += subtotal
                total_tax += iva
            
            total_sale = total_subtotal + total_tax
            update_sale_query = "UPDATE sales SET subtotal = %s, tax = %s, total = %s WHERE id = %s"
            cursor.execute(update_sale_query, (total_subtotal, total_tax, total_sale, sale_id))
            
            conn.commit()

            if (i + 1) % 100 == 0:
                print(f"  ... {i+1}/{NUM_SALES} ventas creadas.")
        
        except mysql.connector.Error as err:
            print(f"Error durante la creación de la venta {i+1}: {err}")
            conn.rollback()
        finally:
            cursor.close()

def main():
    parser = argparse.ArgumentParser(description="Puebla la base de datos de un minimarket con datos de prueba.")
    parser.add_argument('--sales-only', action='store_true', help='Puebla únicamente la tabla de ventas (compras de clientes).')
    args = parser.parse_args()

    conn = create_connection()
    if not conn:
        return

    try:
        if not args.sales_only:
            populate_base_data(conn)
        
        populate_sales(conn)
        print("\nProceso de población de datos completado.")
    finally:
        if conn and conn.is_connected():
            conn.close()
            print("Conexión a la base de datos cerrada.")

if __name__ == "__main__":
    main()
