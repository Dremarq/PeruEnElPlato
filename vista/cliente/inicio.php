<?php
require_once "../../config/conexion.php";
require_once "../../modelo/plato.php";
require_once "../../modelo/Cliente.php";

$plato = new Plato($conexion);

// Obtener los platos
$platos = $plato->obtenerPlatos();







?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurante Perú en el Plato</title>
  <link rel="stylesheet" href="../../public/styles/estilo.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

  <!-- Header Section -->
  <header>
    <nav>
      <ul>
        <li><a href="#reserva-anchor">Reserva</a></li>
        <li><a href="#menu-anchor">Menu</a></li>
        <li><a href="#contact-anchor">Contáctanos</a></li>
        <div class="user-info">
       
        <div><a href="../../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a></div>
      </ul>
    </nav>
  </header>




  <!-- Hero Section -->
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
        aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
        aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
        aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="../../public/img/fondo.png" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="../../public/img/fondo2.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="../../public/img/fondo3.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
      data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
      data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <!-- About Section -->
  <section id="about">
    <div class="about-container">
      <div class="about-text">
        <h2>Acerca de nosotros</h2>
        
        <p>En Perú en el Plato, nos enorgullece ofrecer una experiencia gastronómica que rescata lo mejor de la
          tradición culinaria peruana. Nuestro restaurante combina ingredientes frescos y recetas auténticas para llevar
          a tu mesa los sabores más representativos de la cocina criolla. Desde el irresistible aroma del ají de gallina
          hasta la contundencia del lomo saltado, cada plato es preparado con pasión y dedicación, buscando siempre que
          disfrutes de una explosión de sabor en cada bocado.
          Te invitamos a formar parte de nuestra familia y disfrutar de una experiencia única, donde el sabor y la
          calidez del servicio se unen para crear momentos inolvidables.
          ¡Ven y descubre por qué en Perú en el Plato la comida criolla tiene otro nivel!</p>
      </div>
      <div class="about-image">
        <img src="../../public/img/acerca.jpeg" alt="About Us Image">
      </div>
    </div>
  </section>
  <!-- Menu Section -->
  <section id="menu-anchor">
    <h2 style="text-align: center;">Nuestro Menú <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#menuModal">Comprar</button></h2>


    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="menuModalLabel">Selecciona tus Platos</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <ul class="list-group">
              <?php foreach ($platos as $plato): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <?php echo htmlspecialchars($plato['nombre']); ?> - s/.<?php echo htmlspecialchars($plato['precio']); ?>
                  <button class="btn btn-success btn-sm agregar-carrito" data-id="<?php echo $plato['id_plato']; ?>">Agregar</button>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="ver-carrito">Ver Carrito</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Carrito Modal -->
    <div class="modal fade" id="carritoModal" tabindex="-1" aria-labelledby="carritoModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="carritoModalLabel">Tu Carrito</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <ul class="list-group" id="carrito-list">
              <!-- Aquí se agregarán los platos seleccionados -->
            </ul>
            <p id="total" class="mt-3">Total: $0</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="comprar">Comprar</button>
          </div>
        </div>
      </div>
    </div>

  </section>



  <div class="menu-container">
    <div class="menu-column">
      <h3>Entradas</h3>
      <ul>
        <li>
          <div class="card" style="width: 18rem;">
            <img src="../../public/img/papa.jpg" class="card-img-top" alt="Papa a la Huancaína">
            <div class="card-body">
              <p class="card-text">Papas hervidas servidas con una cremosa salsa de queso, ají amarillo y aceitunas,
                ideales como entrada.</p>
            </div>
          </div>
        </li>
        <li>
          <div class="card" style="width: 18rem;">
            <img src="../../public/img/causa.jpg" class="card-img-top" alt="Causa RellenaS">
            <div class="card-body">
              <p class="card-text">Puré de papa amarilla sazonado con limón y ají, relleno de pollo, atún o mariscos,
                y servido frío.</p>
            </div>
          </div>
        </li>
        <div class="card" style="width: 18rem;">
          <img src="../../public/img/choritos.jpeg" class="card-img-top" alt="Choritos a la Chalaca">
          <div class="card-body">
            <p class="card-text">Mejillones al vapor cubiertos con una mezcla de cebolla, tomate, cilantro y jugo de
              limón, perfectos como aperitivo.</p>
          </div>
        </div>
      </ul>
    </div>
    <div class="menu-column">
      <h3>Platos Principales</h3>
      <ul>
        <li>
          <div class="card" style="width: 18rem;">
            <img src="../../public/img/lomo.jpg" class="card-img-top" alt="Lomo Saltado">
            <div class="card-body">
              <p class="card-text">Jugoso salteado de carne de res con cebolla, tomate y papas fritas, fusionando
                sabores peruanos y chinos.</p>
            </div>
          </div>
        </li>
        <li>
          <div class="card" style="width: 18rem;">
            <img src="../../public/img/ajidegallina.jpg" class="card-img-top" alt="Aji de Gallina">
            <div class="card-body">
              <p class="card-text">Guiso cremoso de pollo desmenuzado en una salsa de ají amarillo, nueces y queso,
                servido sobre arroz.</p>
            </div>
          </div>
        </li>
        <div class="card" style="width: 18rem;">
          <img src="../../public/img/arrozpio.jpg" class="card-img-top" alt="Arroz con Pollo">
          <div class="card-body">
            <p class="card-text">Sazón de arroz cocido con pollo, cilantro y especias, acompañado de verduras frescas.
            </p>
          </div>
        </div>
      </ul>
    </div>
    <div class="menu-column">
      <h3>Postres</h3>
      <ul>
        <li>
          <div class="card" style="width: 18rem;">
            <img src="../../public/img/picarones.jpg" class="card-img-top" alt="picarones">
            <div class="card-body">
              <p class="card-text">Deliciosos buñuelos de masa de zapallo y camote, fritos y bañados en miel de
                chancaca.</p>
            </div>
          </div>
        </li>
        <li>
          <div class="card" style="width: 18rem;">
            <img src="../../public/img/suspiro.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text">Postre suave y dulce hecho con leche condensada, yemas de huevo y merengue, con un
                toque de oporto.</p>
            </div>
          </div>
        </li>
        <div class="card" style="width: 18rem;">
          <img src="../../public/img/turron.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <p class="card-text">Dulce de origen español, elaborado con almendras, miel y clara de huevo, perfecto
              para ocasiones especiales.</p>
          </div>
        </div>
      </ul>
    </div>
  </div>
  </section>
  <!-- Reserva Section -->
  <section id="reserva-anchor">
    <div class="reserva-container">
      <div class="reserva-description">
        <h2 style="text-align: center;">Reserva tu mesa</h2>
        <p style="text-align: center;">Reserva tu mesa en nuestro restaurante y disfruta de una experiencia gastronómica
          única. Por favor, completa el formulario a continuación y nos pondremos en contacto contigo para confirmar tu
          reserva.</p>
        <img style="display: block; margin: 20px auto;" alt="Imagen del restaurante" src="../../public/img/reserva.jpg">
      </div>
      <div class="reserva-form">
        <form>
          <div class="form-group">
            <label for="nombre">Nombre completo:</label>
            <input type="text" id="nombre" name="nombre" required>
          </div>
          <div class="form-group">
            <label for="dni">DNI:</label>
            <input type="dni" id="dni" name="dni" required>
          </div>
          <div class="form-group">
            <label for="telefono">Teléfono celular:</label>
            <input type="tel" id="telefono" name="telefono" required>
          </div>
          <div class="form-group">
            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" required>
          </div>
          <div class="form-group">
            <label for="fecha">Fecha de reserva:</label>
            <input type="date" id="fecha" name="fecha" required>
          </div>
          <div class="form-group">
            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" maxlength="500"></textarea>
            <span id="caracteres">0/500</span>
          </div>
          <button type="submit">Enviar</button>
        </form>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact-anchor">
    <div class="contact-container">
      <div class="social-media">
        <a href="#####" target="_blank">
          <img src="../../public/img/fb.png" alt="Facebook Logo">
        </a>
        <a href="#####" target="_blank">
          <img src="../../public/img/yt.png" alt="YouTube Logo">
        </a>
        <a href="#####" target="_blank">
          <img src="../../public/img/ig.jpeg" alt="Instagram Logo">
        </a>
        <a href="#####" target="_blank">
          <img src="../../public/img/x.png" alt="X Logo">
        </a>
      </div>
      <div class="contact-info">
        <h2>Contáctanos</h2>
        <p>Teléfono: 987654321</p>
        <p>Email: <a href="####">peruenelplato@gmail.com</a></p>
        <p>Dirección: Panamericana Norte, Av. Alfredo Mendiola 6377, Los Olivos</p>
      </div>
    </div>
  </section>
  <!-- Footer Section -->
  <footer>
    <p>&copy; 2024 Restaurante Perú en el Plato. Todos los derechos reservados.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../public/JavaScript/carrito.js"></script>


</body>

</html>