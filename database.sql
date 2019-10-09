CREATE DATABASE IF NOT EXISTS servex_api;
USE servex_api;

/*CREATE TABLE ROLES*/
CREATE TABLE roles(
id 		int(255) auto_increment not null,
name	varchar(30),
status	boolean,
created_at datetime,
updated_at datetime,
created_by int(255) not null,
CONSTRAINT pk_roles PRIMARY KEY(id)
)ENGINE=InnoDb;


/*CREATE TABLE USERS*/
CREATE TABLE users(
id 		int(255) auto_increment not null,
role_id	varchar(255),
name	varchar(255),
surname varchar(255),
email	varchar(255),
password varchar(255),
image	varchar(255),
status	boolean,
created_at datetime,
updated_at datetime,
created_by int(255) not null,
remember_token varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id),
CONSTRAINT fk_users_roles FOREIGN KEY(role_id) REFERENCES roles(id)
)ENGINE=InnoDb;


/*CREATE TABLE CLIENTS*/
CREATE TABLE clients(
id  	int(255) auto_increment not null,
name	varchar(255),
surname varchar(255),
email	varchar(255),
bussiness_name varchar(255),
description text,
logo	varchar(255),
status	boolean,
created_at datetime,
updated_at datetime,
created_by int(255) not null,
CONSTRAINT pk_clients PRIMARY KEY(id),
CONSTRAINT fk_clients_users FOREIGN KEY(created_by) REFERENCES users(id)
)ENGINE=InnoDb;


/*CREATE TABLE CATEGORY*/
CREATE TABLE categories(
id 		int(255) auto_increment not null,
name	varchar(255),
description text,
img	varchar(255),
status	boolean,
created_at datetime,
updated_at datetime,
created_by int(255) not null,
CONSTRAINT pk_categories PRIMARY KEY(id),
CONSTRAINT fk_categories_users FOREIGN KEY(created_by) REFERENCES users(id)
)ENGINE=InnoDb;


/*CREATE TABLE SUBCATEGORY*/
CREATE TABLE subcategories(
id 		int(255) auto_increment not null,
name	varchar(255),
description text,
img	varchar(255),
status	boolean,
created_at datetime,
updated_at datetime,
created_by int(255) not null,
CONSTRAINT pk_subcategories PRIMARY KEY(id),
CONSTRAINT fk_subcategories_users FOREIGN KEY(created_by) REFERENCES users(id)
)ENGINE=InnoDb;


/*CREATE TABLE PRODCUCTS*/
CREATE TABLE products(
id  	int(255) auto_increment not null,
name	varchar(255),
description text,
img	varchar(255),
file_route varchar(255),
status	boolean,
created_at datetime,
updated_at datetime,
created_by int(255) not null,
CONSTRAINT pk_clients PRIMARY KEY(id),
CONSTRAINT fk_products_users FOREIGN KEY(created_by) REFERENCES users(id)
)ENGINE=InnoDb;


/*CREATE TABLE CLIENT-CATEGORIES-SUBCATEGORIES*/
CREATE TABLE cli_cat_subcat(
id 		int(255) auto_increment not null,
client_id int(255) not null,
categorie_id int(255) not null,
subcategorie1_id int(255) not null,
subcategorie2_id int(255) not null,
created_at datetime,
updated_at datetime,
created_by int(255) not null,
CONSTRAINT pk_cli_cat_subcat PRIMARY KEY(id),
CONSTRAINT fk_cli_cat_subcat_client FOREIGN KEY(client_id) REFERENCES clients(id),
CONSTRAINT fk_cli_cat_subcat_categorie FOREIGN KEY(categorie_id) REFERENCES categories(id),
CONSTRAINT fk_cli_cat_subcat_subcategorie1 FOREIGN KEY(subcategorie1_id) REFERENCES subcategories(id),
CONSTRAINT fk_cli_cat_subcat_subcategorie2 FOREIGN KEY(subcategorie2_id) REFERENCES subcategories(id),
CONSTRAINT fk_cli_cat_subcat_users FOREIGN KEY(created_by) REFERENCES users(id)
)ENGINE=InnoDb;



/*CREATE TABLE CLIENT-CATEGORIES-SUBCATEGORIES-PRODUCTS*/
CREATE TABLE cli_cat_subcat_pro(
id 		int(255) auto_increment not null,
client_id int(255) not null,
categorie_id int(255) not null,
subcategorie1_id int(255) not null,
subcategorie2_id int(255) not null,
product_id int(255) not null,
created_at datetime,
updated_at datetime,
created_by int(255) not null,
CONSTRAINT pk_cli_cat_subcat_pro PRIMARY KEY(id),
CONSTRAINT fk_cli_cat_subcat_pro_client FOREIGN KEY(client_id) REFERENCES clients(id),
CONSTRAINT fk_cli_cat_subcat_pro_categorie FOREIGN KEY(categorie_id) REFERENCES categories(id),
CONSTRAINT fk_cli_cat_subcat_pro_subcategorie1 FOREIGN KEY(subcategorie1_id) REFERENCES subcategories(id),
CONSTRAINT fk_cli_cat_subcat_pro_subcategorie2 FOREIGN KEY(subcategorie2_id) REFERENCES subcategories(id),
CONSTRAINT fk_cli_cat_subcat_pro_products FOREIGN KEY(products_id) REFERENCES products(id),
CONSTRAINT fk_cli_cat_subcat_pro_users FOREIGN KEY(created_by) REFERENCES users(id)
)ENGINE=InnoDb;
