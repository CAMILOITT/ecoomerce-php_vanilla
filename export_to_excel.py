
import mysql.connector
import pandas as pd

DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',
    'password': 'mysql@DEV1',
    'database': 'ecommerce'
}

# -----------------------------------------

OUTPUT_FILENAME = 'database_export.xlsx'

def create_connection():
    """Crea y devuelve una conexión a la base de datos."""
    try:
        conn = mysql.connector.connect(**DB_CONFIG)
        print("Conexión a la base de datos establecida con éxito.")
        return conn
    except mysql.connector.Error as err:
        print(f"Error al conectar a la base de datos: {err}")
        return None

def main():
    """
    Exporta datos de varias tablas de la base de datos a un único archivo Excel,
    con cada tabla en una hoja de cálculo separada.
    """
    conn = create_connection()
    if not conn:
        return
    try:
        queries_and_sheets = {
            'products': "SELECT * FROM products;",
            'customers': "SELECT id, name, lastname, email, phone, address, created_at FROM customers;",
            'users': "SELECT id, name, lastname, email, phone, created_at FROM users;",
            'sales_report': """
                SELECT 
                    s.id AS sale_id,
                    s.bill_date,
                    c.name AS customer_name,
                    c.lastname AS customer_lastname,
                    u.name AS seller_name,
                    p.name AS product_name,
                    sd.amount,
                    sd.price,
                    sd.total
                FROM sales s
                JOIN customers c ON s.customer_id = c.id
                JOIN users u ON s.user_id = u.id
                JOIN sale_details sd ON s.id = sd.sale_id
                JOIN products p ON sd.product_id = p.id
                ORDER BY s.bill_date DESC
                LIMIT 5000;
            """
        }
        print(f"Creando archivo Excel: {OUTPUT_FILENAME}...")
        with pd.ExcelWriter(OUTPUT_FILENAME, engine='openpyxl') as writer:
            for sheet_name, query in queries_and_sheets.items():
                print(f"  -> Exportando datos a la hoja '{sheet_name}'...")
                df = pd.read_sql(query, conn)
                df.to_excel(writer, sheet_name=sheet_name, index=False)
        
        print("¡Exportación completada con éxito!")
        print(f"Los datos han sido guardados en el archivo '{OUTPUT_FILENAME}'.")

    except mysql.connector.Error as err:
        print(f"Error de base de datos durante la exportación: {err}")
    except Exception as e:
        print(f"Ha ocurrido un error inesperado: {e}")
    finally:
        if conn and conn.is_connected():
            conn.close()
            print("Conexión a la base de datos cerrada.")

if __name__ == "__main__":
    main()
