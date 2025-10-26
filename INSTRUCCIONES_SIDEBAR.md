# PLANTILLA PARA ACTUALIZAR MÓDULOS CON SIDEBAR

## Instrucciones para actualizar cada módulo:

1. **Reemplazar el inicio del archivo** (líneas 1-20 aproximadamente):

CAMBIAR DE:
```php
<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<a href="app/views/dashboard.php" class="btn btn-inicio-claro position-absolute" style="top:24px;left:24px;z-index:10;"><i class="bi bi-arrow-left"></i> Ir a Inicio</a>
<style>
  .btn-inicio-claro {
    background: #e3f2fd;
    color: #3949ab;
    // ... más estilos
  }
  .MODULO-bg {
    background: linear-gradient(135deg, #f5f7fa 0%, #e3eafc 100%);
    min-height: 100vh;
    padding-top: 40px;
    padding-bottom: 40px;
  }
```

CAMBIAR A:
```php
<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Incluir sidebar -->
        <?php include __DIR__ . '/../sidebar.php'; ?>
        
        <!-- Contenido principal -->
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <style>
```

2. **Actualizar los estilos** (reemplazar los estilos del módulo):

```css
.MODULO-card {
    border-radius: 1.2rem;
    box-shadow: 0 2px 12px rgba(30,40,90,0.10);
    background: #fff;
    border: none;
    padding: 2rem;
    margin-top: 2rem;
}
.MODULO-title {
    color: #1a237e;
    font-weight: 700;
    border-bottom: 3px solid #ffd600;
    margin-bottom: 2rem;
    padding-bottom: 0.5rem;
}
.btn-MODULO {
    background: #3949ab;
    color: #fff;
    border-radius: 2rem;
    font-weight: 600;
    border: 2px solid #ffd600;
    transition: background 0.2s, border 0.2s;
}
.btn-MODULO:hover {
    background: #ffd600;
    color: #3949ab;
    border: 2px solid #3949ab;
}
.btn-MODULO-outline {
    border: 2px solid #3949ab;
    color: #3949ab;
    background: #fff;
    border-radius: 2rem;
    font-weight: 600;
    transition: background 0.2s, color 0.2s;
}
.btn-MODULO-outline:hover {
    background: #3949ab;
    color: #fff;
    border: 2px solid #ffd600;
}
```

3. **Actualizar la estructura HTML** (reemplazar el contenido principal):

CAMBIAR DE:
```html
<div class="MODULO-bg">
  <div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
    <div class="card MODULO-card p-4 w-100" style="max-width:1200px;">
```

CAMBIAR A:
```html
            </style>

            <div class="MODULO-card">
                <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center w-100 gap-5">
                    <div class="w-100" style="max-width:350px;">
                        <h2 class="MODULO-title text-center"><i class="bi bi-ICONO me-2"></i>Gestión de TITULO</h2>
```

4. **Cerrar correctamente** (al final del archivo):

CAMBIAR DE:
```html
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
```

CAMBIAR A:
```html
                </div>
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
```

## ICONOS PARA CADA MÓDULO:

- **accidentes**: `activity`
- **incidentes**: `exclamation-triangle`
- **condicionesinseguras**: `exclamation-diamond`
- **riesgos**: `shield-check`
- **inspeccioneslocativas**: `clipboard-check`
- **reportes**: `file-earmark-text`

## EJEMPLO COMPLETO PARA EL MÓDULO DE INCIDENTES:

Reemplazar "MODULO" por "incidentes", "TITULO" por "Incidentes", "ICONO" por "exclamation-triangle" en la plantilla anterior.

## NOTAS IMPORTANTES:

1. Hacer backup de cada archivo antes de modificar
2. Mantener toda la funcionalidad existente (formularios, tablas, filtros)
3. Solo cambiar la estructura de layout, no la lógica
4. Verificar que los enlaces y formularios funcionen después del cambio
5. Asegurar que los estilos personalizados de cada módulo se mantengan

¡Ya tienes roles, usuarios, empleados y áreas actualizados como ejemplo!