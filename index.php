<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>3D Periodic Table</title>
  <style>
    body {
      margin: 0;
      overflow: hidden;
    }
    canvas {
      display: block;
    }
  </style>
</head>
<body>
  <?php
  // PHP array for periodic table data
  $elements = [
      ["name" => "H", "color" => "0xff0000", "x" => -500, "y" => 200, "z" => 0],
      ["name" => "He", "color" => "0xffa500", "x" => 500, "y" => 200, "z" => 0],
      ["name" => "Li", "color" => "0x00ff00", "x" => -400, "y" => 150, "z" => 0],
      // Add more elements as needed
  ];
  ?>
  
  <script type="module">
    import * as THREE from 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.module.min.js';

    // Scene setup
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0x000000);

    // Camera setup
    const camera = new THREE.PerspectiveCamera(
      75,
      window.innerWidth / window.innerHeight,
      0.1,
      1000
    );
    camera.position.z = 1000;

    // Renderer setup
    const renderer = new THREE.WebGLRenderer();
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.body.appendChild(renderer.domElement);

    // Function to create elements
    function createElement(name, color, x, y, z) {
      const geometry = new THREE.BoxGeometry(50, 50, 50);
      const material = new THREE.MeshBasicMaterial({ color: parseInt(color) });
      const cube = new THREE.Mesh(geometry, material);
      cube.position.set(x, y, z);

      // Add text
      const loader = new THREE.FontLoader();
      loader.load(
        'https://threejs.org/examples/fonts/helvetiker_regular.typeface.json',
        (font) => {
          const textGeometry = new THREE.TextGeometry(name, {
            font: font,
            size: 10,
            height: 2,
          });
          const textMaterial = new THREE.MeshBasicMaterial({ color: 0xffffff });
          const text = new THREE.Mesh(textGeometry, textMaterial);
          text.position.set(x - 20, y + 30, z);
          scene.add(text);
        }
      );

      return cube;
    }

    // Add elements to the scene using PHP data
    <?php foreach ($elements as $element): ?>
    const <?php echo $element["name"]; ?> = createElement(
      "<?php echo $element["name"]; ?>",
      "<?php echo $element["color"]; ?>",
      <?php echo $element["x"]; ?>,
      <?php echo $element["y"]; ?>,
      <?php echo $element["z"]; ?>
    );
    scene.add(<?php echo $element["name"]; ?>);
    <?php endforeach; ?>

    // Animation loop
    function animate() {
      requestAnimationFrame(animate);
      renderer.render(scene, camera);
    }
    animate();
  </script>
</body>
</html>
