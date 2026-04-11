# El Umbral: Asistente de Mundo de Tinieblas (V20) 🦇

Gestor de crónicas y fichas para **Vampiro: La Mascarada (V20)**. Este proyecto permite la gestión avanzada de personajes, incluyendo niveles de **Matusalén** (Atributos y Disciplinas hasta nivel 10).

## 🚀 Estado del Proyecto
Actualmente en fase de **Desarrollo Inicial (Backend)**.
- [x] Configuración de Laravel 11 y MySQL.
- [x] Sistema de Roles jerárquico (Antediluviano, Matusalén, Vástago, Ghoul).
- [x] Migración base de Personajes con soporte para nivel 10.
- [ ] Implementación de Disciplinas y Habilidades.
- [ ] API REST para conexión con Angular.

## 🛠️ Tecnologías utilizadas
- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** Angular (Próximamente)
- **Base de Datos:** MariaDB/MySQL
- **Herramientas:** IntelliJ IDEA, Git

## 📋 Requisitos (Entorno de Desarrollo)
Para ejecutar este proyecto en local (probado en Arch Linux):

1. Clonar el repositorio.
2. Instalar dependencias de PHP: `composer install`
3. Instalar dependencias de JS: `npm install`
4. Configurar el archivo `.env` con tus credenciales de base de datos.
5. Ejecutar migraciones: `php artisan migrate`

## 📖 Notas de Autoría
Proyecto desarrollado como parte del ciclo de **Desarrollo de Aplicaciones Web (DAW)**. Orientado a la automatización de reglas de V20 y soporte para personajes baja generación, (Niveles de estadísticas más altos).
