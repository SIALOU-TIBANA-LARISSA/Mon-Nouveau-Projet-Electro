@extends('layouts.app')

@section('title', $product['name'])

@section('content')
<div class="max-w-7xl mx-auto mt-10 bg-white p-6 rounded-lg">

    <div class="grid grid-cols-1 md:grid-cols-[80px_1fr_1fr] gap-4 items-start">

        <!-- GAUCHE -->
        <div class="flex md:flex-col gap-3 max-h-[400px] overflow-auto">

            <img src="{{ asset($product->main_image_url) }}"
                 class="thumb w-14 h-14 object-cover rounded cursor-pointer border hover:border-blue-500"
                 onclick="showImage(this)">

            @foreach($product->examples as $example)
            <img src="{{ asset($example->image_path) }}"
                 class="thumb w-14 h-14 object-cover rounded cursor-pointer border hover:border-blue-500"
                 onclick="showImage(this)">
            @endforeach

            @if(!empty($product->svg_path))
            <div onclick="showSVG(this)"
                 class="thumb w-20 h-20 bg-gray-200 rounded flex items-center justify-center cursor-pointer border text-xs">
                SVG
            </div>
            @endif

            @if(!empty($product->stl_path))
            <div onclick="show3D(this)"
                 class="thumb w-20 h-20 bg-gray-200 rounded flex items-center justify-center cursor-pointer border text-xs">
                3D
            </div>
            @endif

        </div>

        <!-- MILIEU -->
        <div class="flex justify-center items-start relative">

    <!-- IMAGE -->
    <img id="mainImage"
     onclick="openModal(this)"
         src="{{ asset($product->main_image_url) }}"
         class="w-full max-w-[500px] h-[400px] object-contain mx-auto rounded">

    <!-- SVG -->
    <div id="svgViewer"
     class="hidden w-full h-[400px] flex items-center justify-center relative">

    <!-- TEXTURE -->
    <div id="textureLayer"
         class="hidden absolute inset-0"></div>

    <!-- SVG -->
    <div id="laserViewer"
         class="w-full h-full flex items-center justify-center relative z-10">

        <img id="laserSvg"
             src="{{ asset($product->svg_path ?? '') }}"
             class="max-h-[350px] object-contain">

    </div>

</div>

    <!-- 3D -->
    <div id="viewer3d"
         class="hidden w-full h-[400px] bg-gray-100 rounded flex items-center justify-center">
    </div>

</div>

        <!-- DROITE -->
        <div class="space-y-4">

            <h1 class="text-3xl font-bold mb-3">
                {{ $product['name'] }}
            </h1>

            <div class="text-2xl font-bold text-indigo-600 mb-6">
                {{ number_format($product['price'], 0, ',', ' ') }} FCFA
            </div>

            <p class="text-gray-600 mb-4">
                {{ $product['description'] ?? 'Aucune description disponible.' }}
            </p>

             <!-- Bouton du panier -->
    <button
    class="add-to-cart bg-orange-500 text-white px-5 py-2 rounded-full font-semibold hover:bg-orange-600 transition"
    data-id="{{ $product->id }}">
    Ajouter au panier
</button>


<form action="{{ route('product.favorite', $product->id) }}" method="POST" class="mt-4">
@csrf

<button type="submit"
class="text-2xl transition transform hover:scale-110">

❤️

</button>

</form>

        </div>

    </div>

</div>


<p class="font-semibold mb-2">Choisir le rendu :</p>

<div class="flex justify-center gap-3">

<button onclick="changeColor(this,'bois')" class="render-btn px-3 py-1 border rounded">
Bois
</button>

<button onclick="changeColor(this,'plexi')" class="render-btn px-3 py-1 border rounded">
Plexiglass
</button>

<button onclick="changeColor(this,'noir')" class="render-btn px-3 py-1 border rounded">
Noir
</button>

<button onclick="changeColor(this,'rouge')" class="render-btn px-3 py-1 border rounded">
Rouge
</button>

</div>

</div>

<div class="mt-6 text-center">

<p class="font-semibold mb-2">Charger votre fichier :</p>

<input type="file"
       id="fileUploader"
       accept=".svg,.dxf"
       class="border px-3 py-2 rounded">

<p class="text-sm text-gray-500 mt-2">
Formats acceptés : SVG / DXF
</p>

<button id="resetDesign"
class="mt-3 text-sm text-red-600 underline hidden">
Supprimer le fichier chargé
</button>

</div>

    <hr class="my-8 border-gray-200">

<div class="max-w-4xl mx-auto">

<div class="border-b border-gray-200 mb-6 flex gap-6 justify-center">

    <button onclick="showTab('desc')" class="tab-btn border-b-2 border-orange-500 text-orange-500 pb-2">
        Description
    </button>

    <button onclick="showTab('livraison')" class="tab-btn pb-2">
        Livraison
    </button>

    <button onclick="showTab('avis')" class="tab-btn pb-2">
        Avis
    </button>

</div>

    <!-- Détails du produit -->
     <div id="desc" class="tab-content">

    <h2 class="text-2xl font-bold mb-6">
        📝 Description détaillée
    </h2>

    <!-- TEXTE PRINCIPAL -->
    <p class="text-gray-700 leading-relaxed mb-6">
        {{ $product->description }}
    </p>

    <!-- POINTS FORTS -->
    <div class="bg-gray-50 p-5 rounded-lg mb-6 shadow-sm">

        <h3 class="text-lg font-semibold mb-3">
            ✔ Points forts
        </h3>

        <ul class="space-y-2 text-gray-700">

            <li class="flex items-center gap-2">
                <span class="text-green-500">✔</span>
                Produit personnalisable selon vos besoins
            </li>

            <li class="flex items-center gap-2">
                <span class="text-green-500">✔</span>
                Fabrication de haute qualité
            </li>

            <li class="flex items-center gap-2">
                <span class="text-green-500">✔</span>
                Design moderne et élégant
            </li>

        </ul>

    </div>

    <!-- UTILISATION -->
    <div class="bg-orange-50 p-5 rounded-lg mb-6 shadow-sm">

        <h3 class="text-lg font-semibold mb-2">
             Utilisation
        </h3>

        <p class="text-gray-700">
            Ce produit est parfait pour sublimer votre intérieur, offrir un cadeau
    unique ou répondre à un besoin professionnel. Grâce à sa personnalisation,
    il s’adapte facilement à vos envies et apporte une touche originale
    et élégante à votre espace.
        </p>

    </div>

    <!-- INFOS -->
    <div class="border p-5 rounded-lg">

        <h3 class="text-lg font-semibold mb-3">
            📌 Informations complémentaires
        </h3>

        <ul class="text-gray-700 space-y-2">
            <li><strong>Type :</strong> Produit personnalisable</li>
            <li><strong>Fabrication :</strong> Sur mesure</li>
            <li><strong>Qualité :</strong> Premium</li>
        </ul>

    </div>

</div>

    <!-- Livraison -->
    <div id="livraison" class="tab-content hidden">

    <h2 class="text-2xl font-bold mb-6">
        🚚 Livraison & Expédition
    </h2>

    <!-- ABIDJAN -->
    <div class="bg-gray-50 p-5 rounded-lg mb-4 shadow-sm">

        <h3 class="font-semibold text-lg mb-2">
            📍 Livraison à Abidjan
        </h3>

        <p class="text-gray-700 mb-2">
            Livraison rapide directement à votre domicile ou lieu de travail.
        </p>

        <p class="text-gray-700">
            ⏱ Délai : <strong>24 à 48 heures</strong>
        </p>

    </div>

    <!-- HORS ABIDJAN -->
    <div class="bg-gray-50 p-5 rounded-lg mb-4 shadow-sm">

        <h3 class="font-semibold text-lg mb-2">
            🌍 Livraison hors Abidjan
        </h3>

        <p class="text-gray-700 mb-2">
            Expédition sécurisée partout en Côte d’Ivoire.
        </p>

        <p class="text-gray-700">
            ⏱ Délai : <strong>2 à 5 jours</strong>
        </p>

    </div>

    <!-- OPTIONS -->
    <div class="bg-orange-50 p-5 rounded-lg mb-4 shadow-sm">

        <h3 class="font-semibold text-lg mb-2">
            💳 Options de paiement
        </h3>

        <ul class="text-gray-700 space-y-1">
            <li>✔ Paiement à la livraison disponible</li>
            <li>✔ Paiement mobile (Wave, Orange Money, MTN)</li>
        </ul>

    </div>

    <!-- INFO BONUS -->
    <div class="border p-4 rounded-lg text-gray-700">

        <p>
            📦 Toutes les commandes sont soigneusement préparées et emballées
            pour garantir une réception en parfait état.
        </p>

    </div>

</div>

<hr class="my-8 border-gray-200">

<div id="avis" class="tab-content hidden">
<h2 class="text-xl font-bold mb-4">⭐ Laisser un avis</h2>

<form action="{{ route('review.store', $product->id) }}" method="POST">

@csrf

<label class="block mb-2">Note :</label>

<select name="rating" class="border p-2 rounded mb-3">

<option value="5">⭐⭐⭐⭐⭐</option>
<option value="4">⭐⭐⭐⭐</option>
<option value="3">⭐⭐⭐</option>
<option value="2">⭐⭐</option>
<option value="1">⭐</option>

</select>

<label class="block mb-2">Commentaire :</label>

<textarea name="comment"
class="border p-2 w-full mb-3 rounded"
placeholder="Votre avis sur ce produit"
required></textarea>

<button class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
Envoyer l'avis
</button>

</form>

<hr class="my-8 border-gray-200">

<h2 class="text-xl font-bold mb-4">💬 Avis des clients</h2>

@if($reviews->count() == 0)

<p class="text-gray-500">
Aucun avis pour ce produit pour le moment.
</p>

@else

@foreach($reviews as $review)

<div class="border-b py-4">

<div class="flex items-center mb-2">

<strong class="mr-2">{{ $review->user->name }}</strong>

<span class="text-yellow-500">
@for($i = 1; $i <= $review->rating; $i++)
⭐
@endfor
</span>

</div>

<p class="text-gray-700">
{{ $review->comment }}
</p>

</div>

@endforeach

@endif
</div>
<hr class="my-10">

<h2 class="text-xl font-bold mb-6">🔎 Produits similaires</h2>

<div class="grid grid-cols-2 md:grid-cols-4 gap-6">

@foreach($similarProducts as $item)

<a href="/product/{{ $item->id }}" class="block bg-white shadow rounded p-4 hover:shadow-lg">

<img src="{{ asset($item->main_image_url) }}"
class="w-full h-40 object-contain mb-3">

<h3 class="font-semibold mb-2">
{{ $item->name }}
</h3>

<p class="text-orange-600 font-bold">
{{ number_format($item->price,0,',',' ') }} FCFA
</p>

</a>

@endforeach

</div>


<style>
.card3d {
    position: relative;
    overflow: hidden;
    border-radius: 16px;
    transition: 
        transform 0.4s ease,
        box-shadow 0.4s ease,
        background-color 0.4s ease;
    background-color: #f3f4f6; /* bg-gray-100 */
}

.card3d:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0,0,0,0.18);
    background-color: #fff7ed; /* léger orange crème */
}

.product-image {
    transition: transform 0.4s ease;
}

.shine {
    position: absolute;
    top: 0;
    left: -150%;
    width: 200%;
    height: 100%;
    background: linear-gradient(
        120deg,
        rgba(255,255,255,0) 0%,
        rgba(255,255,255,0.35) 50%,
        rgba(255,255,255,0) 100%
    );
    transition: left 0.6s ease;
    pointer-events: none;
}

.card3d:hover .shine {
    left: 100%;
}


.svg-preview{
position:relative;
display:inline-block;
}

.svg-preview img{
position:relative;
z-index:3;
}


.texture{
position:absolute;
top:0;
left:0;
width:100%;
height:100%;

background-size:cover;
background-repeat:no-repeat;
background-position:center;

pointer-events:none;
z-index:1;
}

#laserSvg{
filter: contrast(140%) brightness(85%);
}

.svg-preview{
position:relative;
display:inline-block;
padding:20px;
border-radius:8px;
box-shadow:0 10px 25px rgba(0,0,0,0.25);
background:white;
}

#laserSvg{
filter: contrast(140%) brightness(85%);
mix-blend-mode:multiply;
}

#laserViewer svg{
mix-blend-mode: multiply;
}

#textureLayer{
    background-size: cover;
    background-position: center;
    mix-blend-mode: multiply;
    pointer-events: none;
}
.active {
    border: 3px solid #2563eb !important;
    transform: scale(1.1);
}

</style>

<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll('.card3d').forEach(card => {

        const image = card.querySelector('.product-image');
        let scale = 1;

        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;

            card.style.transform = `
                rotateX(${ -y * 15 }deg)
                rotateY(${ x * 15 }deg)
                translateY(-6px)
            `;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = "rotateX(0deg) rotateY(0deg)";
        });

        card.addEventListener('wheel', e => {
            e.preventDefault();
            scale += e.deltaY * -0.003;
            scale = Math.min(Math.max(1, scale), 3);
            image.style.transform = `scale(${scale})`;
        });

    });

});
</script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/STLLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

<script src="https://cdn.jsdelivr.net/npm/dxf-parser/dist/dxf-parser.js"></script>


<script>
function init3D(){

    const container = document.getElementById("viewer3d");
    if (!container) return;

    container.innerHTML = ""; // reset

    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xffffff);

    const camera = new THREE.PerspectiveCamera(
        60,
        container.clientWidth / container.clientHeight,
        0.1,
        1000
    );

    camera.position.set(0, 60, 120);

    const renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(container.clientWidth, container.clientHeight);
    container.appendChild(renderer.domElement);

    scene.add(new THREE.AmbientLight(0xffffff, 0.6));

    const light = new THREE.DirectionalLight(0xffffff, 0.8);
    light.position.set(50, 50, 50);
    scene.add(light);

    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;

    const loader = new THREE.STLLoader();
    loader.load("{{ asset($product->stl_path) }}", function (geometry) {

        geometry.center();

        const material = new THREE.MeshStandardMaterial({
            color: 0x2563eb
        });

        const mesh = new THREE.Mesh(geometry, material);
        mesh.rotation.x = -Math.PI / 2;
        scene.add(mesh);
    });

    function animate() {
        requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    }

    animate();
}
function initModal3D(){

    const container = document.getElementById("modal3D");
    container.innerHTML = "";

    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xffffff);

    const camera = new THREE.PerspectiveCamera(
        60,
        container.clientWidth / container.clientHeight,
        0.1,
        1000
    );

    camera.position.set(0, 60, 120);

    const renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(container.clientWidth, container.clientHeight);
    container.appendChild(renderer.domElement);

    scene.add(new THREE.AmbientLight(0xffffff, 0.6));

    const light = new THREE.DirectionalLight(0xffffff, 0.8);
    light.position.set(50, 50, 50);
    scene.add(light);

    const controls = new THREE.OrbitControls(camera, renderer.domElement);

    const loader = new THREE.STLLoader();
    loader.load("{{ asset($product->stl_path) }}", function (geometry) {

        geometry.center();

        const material = new THREE.MeshStandardMaterial({ color: 0x2563eb });
        const mesh = new THREE.Mesh(geometry, material);
        mesh.rotation.x = -Math.PI / 2;

        scene.add(mesh);
    });

    function animate(){
        requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    }

    animate();
}
</script>

<script>
function changeColor(button,type){

const texture = document.getElementById("textureLayer");
const svgImg = document.getElementById("laserSvg");
const dxfLines = document.querySelectorAll("#laserViewer svg line, #laserViewer svg polyline");
if(svgImg){
svgImg.style.filter="";
}

document.querySelectorAll(".render-btn").forEach(btn=>{
btn.classList.remove("bg-black","text-white");
});

button.classList.add("bg-black","text-white");

if(type==="bois"){
texture.classList.remove("hidden");
texture.style.opacity = "0.6";
texture.style.backgroundImage="url('/textures/wood.jpg')";
}

if(type==="plexi"){
texture.classList.remove("hidden");
texture.style.backgroundImage="url('/textures/plexi-new.jpg')";
}

if(type==="noir"){
texture.classList.add("hidden");
if(svgImg){
svgImg.style.filter="brightness(0)";
}

dxfLines.forEach(l=>{
l.setAttribute("stroke","black");
});
}

if(type==="rouge"){
texture.classList.add("hidden");

if(svgImg){
svgImg.style.filter="invert(20%) sepia(100%) saturate(6000%) hue-rotate(-10deg)";
}

dxfLines.forEach(l=>{
l.setAttribute("stroke","red");
});
}
}

</script>

<script>

document.addEventListener("DOMContentLoaded", function(){

const uploader = document.getElementById("fileUploader");
const preview = document.getElementById("laserSvg");
const viewer = document.getElementById("laserViewer");
const resetBtn = document.getElementById("resetDesign");

if(!uploader || !viewer) return;

const originalSvg = preview.src;

uploader.addEventListener("change", function(event){

const file = event.target.files[0];
if(!file) return;

const reader = new FileReader();

if(file.name.endsWith(".svg")){

    reader.onload = function(e){

        preview.src = e.target.result;

        // afficher le SVG
        document.getElementById('mainImage').style.display = "none";
        document.getElementById('svgViewer').classList.remove("hidden");
        document.getElementById('viewer3d').classList.add("hidden");

        preview.style.display = "block";

        resetBtn.classList.remove("hidden");
    };

    reader.readAsDataURL(file);
}

else if(file.name.endsWith(".dxf")){

preview.style.display="none";
viewer.innerHTML="";

const reader = new FileReader();

reader.onload = function(e){

const parser = new DxfParser();
const dxf = parser.parseSync(e.target.result);

console.log(dxf);

const svg = document.createElementNS("http://www.w3.org/2000/svg","svg");
svg.setAttribute("width","100%");
svg.setAttribute("height","350");
svg.setAttribute("viewBox","0 0 500 500");

svg.style.position = "relative";
svg.style.zIndex = "3";

dxf.entities.forEach(entity => {

if(entity.type === "LINE"){

const line = document.createElementNS("http://www.w3.org/2000/svg","line");

line.setAttribute("x1", entity.vertices[0].x);
line.setAttribute("y1", entity.vertices[0].y);
line.setAttribute("x2", entity.vertices[1].x);
line.setAttribute("y2", entity.vertices[1].y);

line.setAttribute("stroke","black");
line.setAttribute("opacity","0.8");
line.setAttribute("stroke-width","1");

svg.appendChild(line);

}

else if(entity.type === "LWPOLYLINE" || entity.type === "POLYLINE"){

const points = entity.vertices.map(v => v.x + "," + v.y).join(" ");

const polyline = document.createElementNS("http://www.w3.org/2000/svg","polyline");

polyline.setAttribute("points", points);
polyline.setAttribute("stroke","black");
polyline.setAttribute("opacity","0.8");
polyline.setAttribute("stroke-width","1");
polyline.setAttribute("fill","none");

svg.appendChild(polyline);

}

});

viewer.appendChild(svg);

};

reader.readAsText(file);

resetBtn.classList.remove("hidden");

}

else{

alert("Formats acceptés : SVG ou DXF");

}

});

resetBtn.addEventListener("click",function(){

preview.src = originalSvg;
preview.style.display="block";

uploader.value="";
resetBtn.classList.add("hidden");

});

});
</script>

<script>
function showImage(el){

    document.getElementById('mainImage').style.display = "block";
    document.getElementById('mainImage').src = el.src;

    document.getElementById('svgViewer').classList.add("hidden");
    document.getElementById('viewer3d').classList.add("hidden");

    // 🔥 ajouter ça seulement
    document.querySelectorAll('.thumb').forEach(e => e.classList.remove('active'));
    el.classList.add('active');
}

function showSVG(el){

    document.getElementById('mainImage').style.display = "none";
    document.getElementById('svgViewer').classList.remove("hidden");
    document.getElementById('viewer3d').classList.add("hidden");

    document.querySelectorAll('.thumb').forEach(e => e.classList.remove('active'));
    el.classList.add('active');
}

function show3D(el){

    document.getElementById('mainImage').style.display = "none";
    document.getElementById('svgViewer').classList.add("hidden");

    const viewer = document.getElementById('viewer3d');
    viewer.classList.remove("hidden");

    document.querySelectorAll('.thumb').forEach(e => e.classList.remove('active'));
    el.classList.add('active');

    init3D();
}

</script>

<script>
function openModal(img){
    document.getElementById("imageModal").classList.remove("hidden");

    document.getElementById("modalMainImage").src = img.src;

    document.getElementById("modalMainImage").classList.remove("hidden");
    document.getElementById("modalSvg").classList.add("hidden");
    document.getElementById("modal3D").classList.add("hidden");
}

function closeModal(){
    document.getElementById("imageModal").classList.add("hidden");
}

function changeModalImage(el){

    document.getElementById("modalMainImage").src = el.src;

    // 🔥 gestion sélection
    document.querySelectorAll('#imageModal .thumb')
        .forEach(e => e.classList.remove('active'));

    el.classList.add('active');

    document.getElementById("modalMainImage").classList.remove("hidden");
    document.getElementById("modalSvg").classList.add("hidden");
    document.getElementById("modal3D").classList.add("hidden");
}

function showModalSVG(el){

    document.getElementById("modalMainImage").classList.add("hidden");
    document.getElementById("modalSvg").classList.remove("hidden");
    document.getElementById("modal3D").classList.add("hidden");

    document.querySelectorAll('#imageModal .thumb')
        .forEach(e => e.classList.remove('active'));

    el.classList.add('active');
}

function showModal3D(el){

    document.getElementById("modalMainImage").classList.add("hidden");
    document.getElementById("modalSvg").classList.add("hidden");

    const container = document.getElementById("modal3D");
    container.classList.remove("hidden");

    document.querySelectorAll('#imageModal .thumb')
        .forEach(e => e.classList.remove('active'));

    el.classList.add('active');

    initModal3D();
}
</script>
<script>
function showTab(tab){

    document.querySelectorAll('.tab-content').forEach(el=>{
        el.classList.add('hidden');
    });

    document.getElementById(tab).classList.remove('hidden');

    document.querySelectorAll('.tab-btn').forEach(btn=>{
        btn.classList.remove('border-b-2','border-orange-500','text-orange-500');
    });

    event.target.classList.add('border-b-2','border-orange-500','text-orange-500');
}
</script>

<div id="imageModal"
     class="hidden fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50">

    <div class="bg-white w-[90%] max-w-5xl rounded-lg p-6 relative flex gap-6">

        <!-- BOUTON FERMER -->
        <button onclick="closeModal()"
                class="absolute top-3 right-3 text-2xl font-bold">
            ✕
        </button>

        <!-- IMAGE GRANDE -->
        <div class="w-3/4 flex items-center justify-center relative">

    <!-- IMAGE -->
    <img id="modalMainImage"
         class="max-h-[500px] object-contain">

    <!-- SVG -->
    <img id="modalSvg"
         src="{{ asset($product->svg_path ?? '') }}"
         class="hidden max-h-[500px] object-contain">

    <!-- 3D -->
    <div id="modal3D"
         class="hidden w-full h-[500px]"></div>

</div>
        <!-- MINIATURES -->
        <div class="w-1/4 flex flex-col gap-2 overflow-y-auto">

            <img src="{{ asset($product->main_image_url) }}"
                 class="thumb w-20 h-20 object-cover cursor-pointer border"
                 onclick="changeModalImage(this)">

            @foreach($product->examples as $example)
            <img src="{{ asset($example->image_path) }}"
                 class="thumb w-20 h-20 object-cover cursor-pointer border"
                 onclick="changeModalImage(this)">
            @endforeach

            @if(!empty($product->svg_path))
<div onclick="showModalSVG(this)"
     class="thumb w-20 h-20 bg-gray-200 flex items-center justify-center cursor-pointer border text-xs">
    SVG
</div>
@endif

@if(!empty($product->stl_path))
<div onclick="showModal3D(this)"
     class="thumb w-20 h-20 bg-gray-200 flex items-center justify-center cursor-pointer border text-xs">
    3D
</div>
@endif

        </div>

    </div>

</div>
@endsection
