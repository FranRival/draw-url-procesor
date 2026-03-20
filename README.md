# 🗑️ Trash Posts Processor

Plugin de WordPress para enviar múltiples posts a la papelera (Trash) de forma masiva usando URLs o IDs.

---

## 🚀 ¿Qué hace este plugin?

Este plugin permite:

- Pegar múltiples URLs o Post IDs en un solo textbox
- Procesarlos en bloque (bulk)
- Enviar automáticamente esos posts a la papelera (Trash)

---

## 🎯 Problema que resuelve

Cuando tienes contenido con errores como:

- Imágenes 404
- Timeouts
- Contenido roto o incompleto

👉 Ese contenido sigue siendo accesible en el frontend  
👉 Los usuarios pueden entrar y tener una mala experiencia  

Normalmente tendrías que:

- Buscar post por post
- Revisar manualmente
- Eliminar uno por uno

❌ Lento  
❌ Ineficiente  
❌ No escalable  

---

## ✅ Solución

Con este plugin:

- Pegas todas las URLs problemáticas
- Das clic en **Procesar**
- Todos los posts se envían a **Trash automáticamente**

👉 Eliminando del frontend cualquier acceso a contenido defectuoso  
👉 Ahorrando horas de trabajo manual  

---

## ⚙️ Cómo funciona

1. Ve a `WP-Admin > Trash Processor`
2. Pega URLs o IDs (1 por línea)

Ejemplo:  

.com/post-1  
.com/post-2  

433  
782  


3. Haz clic en **Procesar**

---

## 🧠 Qué ocurre internamente

- Detecta si el valor es:
  - URL → se convierte a Post ID
  - ID → se usa directamente
- Verifica que el post exista
- Ejecuta:

php
wp_trash_post($post_id);


### 🔒 Seguridad

- No elimina permanentemente
- Los posts se envían a la papelera (Trash)
- Puedes restaurarlos en cualquier momento

### ⚡ Ventajas

- Procesamiento masivo (bulk)
- Ahorro de tiempo significativo
- Evita errores humanos
- Mejora la experiencia del usuario (UX)
- Limpieza rápida de contenido defectuoso

### ⚠️ Consideraciones

- url_to_postid() depende de:
- Permalinks bien configurados
- URLs internas válidas
- URLs incorrectas pueden no mapear correctamente a un post

### 📌 Casos de uso

- Limpieza tras auditorías SEO
- Eliminación de contenido con imágenes rotas
- Depuración masiva de posts antiguos
- Corrección de errores detectados por crawlers o scanners

### 🧩 Futuras mejoras 

- Preview antes de enviar a Trash
- Logs de posts eliminados
- Filtros por condiciones (ej: número de errores)
- Integración con scanners automáticos

### 👨‍💻 Autor

Desarrollado como herramienta interna para automatización y mantenimiento de contenido en WordPress. Marca EmmanuelIbarra.com