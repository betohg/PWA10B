<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="icon" href="{{ asset('icons/icono.png') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* Mueve las tabs al fondo de la página */
    .nav-tabs {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        margin: 0;
        border-top: none;
        border-bottom: 2px solid #ddd;
    }

    .tab-content {
        margin-bottom: 50px;
        /* Para dar espacio por debajo de la sección de contenido */
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        /* Sombra más marcada */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .nav-tabs .nav-link.active {
        background-color: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
    }

    .nav-tabs .nav-link {
        color: #6c757d;
    }


    .nav-link:hover {
        background-color: #f8f9fa;
        /* Fondo claro */
        color: #0d6efd;
        /* Azul Bootstrap */
        transition: background-color 0.3s ease, color 0.3s ease;
        /* Animación suave */
    }

    body {
        background-color: #f8f9fa;
        /* Fondo general */
    }

    @media (max-width: 576px) {
        .card {
            padding: 0.5rem;
        }

        .card-title {
            font-size: 1rem;
            /* Título más pequeño */
        }

        .card-text {
            font-size: 0.85rem;
            /* Texto más compacto */
        }
    }
    </style>
</head>

<body>
    <!-- Navbar con botón de deslogueo -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('icons/icono.png') }}" alt="Logo" width="30" height="30" class="d-inline-block align-top me-2">
                App Inventario
            </a>
            <div class="d-flex">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-light" type="submit">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>


    <div class="container mt-4">

        <!-- Tab content -->
        <div class="tab-content mt-3" id="dashboardTabsContent">
            <!-- Home Tab (Productos) -->
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <h2 class="text-center">PRODUCTOS</h2>
                <!-- Contenedor para los productos -->
                <div class="row" id="products-list"></div>
            </div>

            <!-- Profile Tab (Movimientos) -->
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <h2 class="text-center">MIS MOVIMIENTOS</h2>
                <!-- Contenedor para los movimientos -->
                <div class="row" id="movements-list"></div>
            </div>

            <!-- Reportes Tab (Filtros y PDF) -->
            <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                <h2 class="text-center">GENERAR REPORTE DE MOVIMIENTOS</h2>
                <form id="filterForm">
                    <div class="mb-3">
                        <label for="movementType" class="form-label">Tipo de Movimiento</label>
                        <select class="form-select" id="movementType" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="1">Entrada</option>
                            <option value="2">Salida</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="startDate">
                    </div>
                    <div class="mb-3">
                        <label for="endDate" class="form-label">Fecha de Fin</label>
                        <input type="date" class="form-control" id="endDate">
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" id="generatesubmitPdfBtn" class="btn btn-primary me-3">Generar
                            PDF</button>



                    </div>
                    <hr>
                </form>
                <div class="d-flex justify-content-center mt-4">
                <button id="downloadPdfBtn" class="btn btn-success">Descargar PDF</button>




                    </div>
                <div id="movements-list-report" class="mt-3"></div>

                

            </div>
        </div>
    </div>

    <ul class="nav nav-tabs justify-content-center" id="dashboardTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active text-center" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
            role="tab" aria-controls="home" aria-selected="true">
            <img src="{{ asset('icons/home.png') }}" alt="Home Icon" width="30" height="30"><br>
            Home
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link text-center" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
            role="tab" aria-controls="profile" aria-selected="false">
            <img src="{{ asset('icons/order.png') }}" alt="Home Icon" width="30" height="30"><br>
            Movimientos
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link text-center" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button"
            role="tab" aria-controls="settings" aria-selected="false">
            <img src="{{ asset('icons/report.png') }}" alt="Home Icon" width="30" height="30"><br>
            Reportes
        </button>
    </li>
</ul>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const productsList = document.getElementById('products-list');
        const movementsList = document.getElementById('movements-list');
        const movementsListReport = document.getElementById('movements-list-report');
        const filterForm = document.getElementById('filterForm');
        const downloadPdfBtn = document.getElementById('downloadPdfBtn');
        const movementTypeSelect = document.getElementById('movementType');
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');

        fetch('/api/products')
            .then(response => response.json())
            .then(data => {
                data.forEach(product => {
                    const productCard = `
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card shadow-lg h-100"> <!-- Clase h-100 para igualar alturas -->
                                <img src="/storage/${product.image_path}" 
                                    class="card-img-top img-fluid" 
                                    style="object-fit: cover; height: 200px;" 
                                    alt="${product.name}">
                                <div class="card-body d-flex flex-column"> <!-- Flex para alinear contenido -->
                                    <!-- Título destacado -->
                                    <h5 class="card-title fw-bold text-primary text-truncate">${product.name}</h5>
                                    
                                    <!-- Descripción en un color más claro -->
                                    <p class="card-text text-muted text-truncate">${product.description}</p>
                                    
                                    <!-- Cantidad con icono -->
                                    <p class="card-text">
                                        <span class="fw-semibold">Cantidad:</span> 
                                        <span>${product.quantity}</span>
                                    </p>
                                    
                                    <!-- Precio destacado -->
                                    <p class="card-text">
                                        <span class="fw-semibold">Precio:</span> 
                                        <span class="text-success fw-bold">$${product.price}</span>
                                    </p>
                                </div>
                            </div>
                        </div>


                    `;
                    productsList.innerHTML += productCard;
                });
            })
            .catch(error => console.error('Error fetching products:', error));


        function loadMovements(filters = {}) {
            const queryParams = new URLSearchParams(filters).toString();
            const url = `/api/movementspdf?${queryParams}`;
            console.log('Loading movements with URL:', url); // Debug URL

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    movementsList.innerHTML = '';
                    data.forEach(movement => {
                        const productName = movement.product ? movement.product.name :
                            'Producto desconocido';
                        const movementTypeName = movement.movement_type.name;
                        const userName = movement.user ? movement.user.name : 'Usuario desconocido';
                        console.log(userName)
                        console.log(productName)

                        const movementCard = `
                            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Movimiento ID: ${movement.movement_id}</h5>
                                        <p class="card-text">Producto: ${productName}</p>
                                        <p class="card-text">Cantidad: ${movement.quantity}</p>
                                        <p class="card-text">Fecha: ${new Date(movement.movement_date).toLocaleString()}</p>
                                        <p class="card-text">Tipo de Movimiento: ${movementTypeName}</p>
                                        <p class="card-text">Usuario: ${userName}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        movementsList.innerHTML += movementCard;
                    });
                })
                .catch(error => console.error('Error fetching movements:', error));
        }

        filterForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const userConfirmed = confirm("¿Está seguro que desea generar el reporte en PDF?");

            if (!userConfirmed) {
                console.log("Generación de PDF cancelada.");
                return;
            }

            const filters = {
                movement_type_id: movementTypeSelect.value,
                start_date: startDateInput.value,
                end_date: endDateInput.value
            };

            console.log('Filters applied:', filters); // Debug filters

            loadMovements(filters);


        });

        downloadPdfBtn.addEventListener('click', function() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();
            console.log(movementsListReport.innerHTML); // Revisa si contiene los movimientos esperados

            const movementTypeText = movementTypeSelect.options[movementTypeSelect.selectedIndex].text;
            const startDate = startDateInput.value || "Sin fecha de inicio";
            const endDate = endDateInput.value || "Sin fecha de fin";

            // Generar el nombre del archivo PDF con la hora actual y el tipo de movimiento
            const currentDate = new Date();
            const formattedDate = currentDate.toISOString().replace(/[-T:.]/g, "").slice(0,
            14); // Formato: yyyyMMddHHmmss
            const pdfFileName = `reporte_${formattedDate}_${movementTypeText}.pdf`;

            doc.setFontSize(18);
            doc.text("Reporte de Movimientos de Inventario", 20, 20);

            doc.setFontSize(12);
            doc.text(`Tipo de Movimiento: ${movementTypeText}`, 20, 30);
            doc.text(`Rango de Fechas: ${startDate} a ${endDate}`, 20, 40);

            // Crear tabla con celdas
            let y = 50;
            doc.setFontSize(12);

            // Títulos de las columnas
            doc.text('Producto', 20, y);
            doc.text('Cantidad', 80, y);
            doc.text('Fecha', 140, y);
            y += 10;

            // Dibujar una línea debajo de los títulos de las columnas
            doc.line(20, y, 200, y);
            y += 5;

            // Recorrer los movimientos y agregarlos a la tabla
            const movements = movementsList.querySelectorAll('.card-body');



          

            movements.forEach(movement => {
                const productName = movement.querySelector('.card-text:nth-child(2)')
                    .innerText || 'Producto desconocido';
                const quantity = movement.querySelector('.card-text:nth-child(3)').innerText;
                const date = movement.querySelector('.card-text:nth-child(4)').innerText;

                doc.text(productName, 20, y);
                doc.text(quantity, 80, y);
                doc.text(date, 140, y);
                y += 10;

                // Verificar si se llega al final de la página y agregar una nueva página si es necesario
                if (y > 270) {
                    doc.addPage();
                    y = 20;
                }
            });

            // Guardar el PDF con el nombre generado
            doc.save(pdfFileName);
        });

        loadMovements();
    });
    </script>
</body>

</html>