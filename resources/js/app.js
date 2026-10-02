import "./bootstrap";
import * as THREE from "three";

const stage = document.querySelector("[data-book-scene]");

if (stage) {
    const canvas = stage.querySelector("canvas");
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(32, 1, 0.1, 100);
    const renderer = new THREE.WebGLRenderer({
        canvas,
        alpha: true,
        antialias: true,
    });
    const book = new THREE.Group();
    const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");
    const stageLink = stage.dataset.bookLink || "/mahasiswa";
    let hoverScale = 1;
    let targetHoverScale = 1;

    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    renderer.outputColorSpace = THREE.SRGBColorSpace;
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.12;

    camera.position.set(3.2, 2.1, 5.1);
    camera.lookAt(-0.42, 0, 0);

    scene.add(new THREE.HemisphereLight(0xf2f5ec, 0x263e4a, 2.1));

    const keyLight = new THREE.DirectionalLight(0xfff2d8, 3.2);
    keyLight.position.set(-3.5, 5.8, 4.5);
    keyLight.castShadow = true;
    keyLight.shadow.mapSize.set(1536, 1536);
    keyLight.shadow.camera.left = -5;
    keyLight.shadow.camera.right = 5;
    keyLight.shadow.camera.top = 4;
    keyLight.shadow.camera.bottom = -4;
    keyLight.shadow.camera.near = 0.5;
    keyLight.shadow.camera.far = 20;
    keyLight.shadow.bias = -0.00035;
    keyLight.shadow.radius = 6;
    scene.add(keyLight);

    const fillLight = new THREE.DirectionalLight(0x8bc5c0, 1.2);
    fillLight.position.set(4, 1, -4);
    scene.add(fillLight);

    const coverMaterial = new THREE.MeshStandardMaterial({
        color: 0x1e5fd7,
        roughness: 0.58,
        metalness: 0.04,
    });
    const paperMaterial = new THREE.MeshStandardMaterial({
        color: 0xeee7d4,
        roughness: 0.94,
    });
    const ridgeMaterial = new THREE.MeshStandardMaterial({
        color: 0xcfc5ad,
        roughness: 1,
    });
    const goldMaterial = new THREE.MeshStandardMaterial({
        color: 0xd3b77a,
        roughness: 0.7,
        metalness: 0.16,
    });

    const addBox = (width, height, depth, material, position) => {
        const mesh = new THREE.Mesh(
            new THREE.BoxGeometry(width, height, depth),
            material,
        );
        mesh.position.set(...position);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        book.add(mesh);
        return mesh;
    };

    // The paper sits inside the boards, leaving a visible hardcover overhang.
    addBox(1.34, 1.94, 0.25, paperMaterial, [0.035, 0, 0]);
    addBox(1.5, 2.1, 0.02, coverMaterial, [0, 0, 0.135]);
    addBox(1.5, 2.1, 0.02, coverMaterial, [0, 0, -0.135]);
    addBox(0.13, 2.1, 0.29, coverMaterial, [-0.685, 0, 0]);

    const ridgeCount = 52;
    const topRidges = new THREE.InstancedMesh(
        new THREE.BoxGeometry(1.31, 0.0012, 0.0014),
        ridgeMaterial,
        ridgeCount * 2,
    );
    const sideRidges = new THREE.InstancedMesh(
        new THREE.BoxGeometry(0.0012, 1.91, 0.0014),
        ridgeMaterial,
        ridgeCount,
    );
    const ridgeTransform = new THREE.Object3D();

    for (let index = 0; index < ridgeCount; index += 1) {
        const depth = -0.119 + index * (0.238 / (ridgeCount - 1));
        ridgeTransform.position.set(0.035, 0.971, depth);
        ridgeTransform.updateMatrix();
        topRidges.setMatrixAt(index, ridgeTransform.matrix);
        ridgeTransform.position.y = -0.971;
        ridgeTransform.updateMatrix();
        topRidges.setMatrixAt(index + ridgeCount, ridgeTransform.matrix);
        ridgeTransform.position.set(0.706, 0, depth);
        ridgeTransform.updateMatrix();
        sideRidges.setMatrixAt(index, ridgeTransform.matrix);
    }
    topRidges.instanceMatrix.needsUpdate = true;
    sideRidges.instanceMatrix.needsUpdate = true;

    // Two restrained gold rules make the cover read as a finished cloth board.
    const coverFront = 0.146;
    addBox(1.25, 0.008, 0.001, goldMaterial, [0, 0.79, 0.149]);
    addBox(1.25, 0.008, 0.001, goldMaterial, [0, -0.79, 0.149]);
    addBox(0.008, 1.58, 0.001, goldMaterial, [-0.62, 0, 0.149]);
    addBox(0.008, 1.58, 0.001, goldMaterial, [0.62, 0, 0.149]);

    const coverCanvas = document.createElement("canvas");
    coverCanvas.width = 512;
    coverCanvas.height = 720;
    const context = coverCanvas.getContext("2d");
    context.fillStyle = "#1e5fd7";
    context.fillRect(0, 0, coverCanvas.width, coverCanvas.height);
    context.strokeStyle = "rgba(226, 205, 157, 0.13)";
    context.lineWidth = 1;
    for (let line = 0; line < 720; line += 5) {
        context.beginPath();
        context.moveTo(0, line);
        context.lineTo(512, line);
        context.stroke();
    }
    context.strokeStyle = "#d3b77a";
    context.lineWidth = 2;
    context.strokeRect(42, 42, 428, 636);
    context.strokeRect(49, 49, 414, 622);
    context.textAlign = "center";
    context.fillStyle = "#f2e7cb";
    context.font = "600 22px Georgia, serif";
    context.fillText("RUANG KERJA AKADEMIK", 256, 265);
    context.font = "600 54px Georgia, serif";
    context.fillText("DATA", 256, 340);
    context.fillText("KAMPUS", 256, 405);
    context.fillStyle = "#d3b77a";
    context.fillRect(150, 365, 212, 2);
    context.fillStyle = "#d9d3c5";
    context.font = "20px Georgia, serif";
    context.fillText("PROGRAM STUDI  /  MAHASISWA", 256, 455);

    const coverTexture = new THREE.CanvasTexture(coverCanvas);
    coverTexture.colorSpace = THREE.SRGBColorSpace;
    const coverArt = new THREE.Mesh(
        new THREE.PlaneGeometry(1.5, 2.1),
        new THREE.MeshStandardMaterial({ map: coverTexture, roughness: 0.7 }),
    );
    coverArt.position.z = coverFront + 0.001;
    coverArt.castShadow = true;
    book.add(coverArt);

    [0.72, -0.72].forEach((height) => {
        addBox(0.075, 0.008, 0.002, goldMaterial, [-0.685, height, 0]);
    });

    book.add(topRidges, sideRidges);
    book.position.x = -0.45;
    book.rotation.set(0.17, -0.55, -0.06);
    book.scale.setScalar(1);
    scene.add(book);

    const floor = new THREE.Mesh(
        new THREE.PlaneGeometry(30, 30),
        new THREE.ShadowMaterial({ opacity: 0.28 }),
    );
    floor.rotation.x = -Math.PI / 2;
    floor.position.y = -1.3;
    floor.receiveShadow = true;
    scene.add(floor);

    const resize = () => {
        const { width, height } = stage.getBoundingClientRect();
        if (!width || !height) return;
        renderer.setSize(width, height, false);
        camera.aspect = width / height;
        camera.position.z = width < 520 ? 6.1 : 4.6;
        camera.updateProjectionMatrix();
    };

    const resizeObserver = new ResizeObserver(resize);
    resizeObserver.observe(stage);
    resize();

    let speed = reducedMotion.matches ? 0 : 0.28;
    let targetSpeed = speed;
    let previousTime = 0;
    const animate = (time) => {
        const elapsed = previousTime
            ? Math.min((time - previousTime) / 1000, 0.05)
            : 0;
        previousTime = time;
        speed += (targetSpeed - speed) * Math.min(elapsed * 2.5, 1);
        hoverScale +=
            (targetHoverScale - hoverScale) * Math.min(elapsed * 8, 1);
        book.rotation.y += speed * elapsed;
        book.scale.setScalar(hoverScale);
        renderer.render(scene, camera);
        requestAnimationFrame(animate);
    };

    stage.style.cursor = "pointer";

    const setHoverScale = (nextScale) => {
        targetHoverScale = nextScale;
    };

    stage.addEventListener("mouseenter", () => {
        targetSpeed = 0.65;
        setHoverScale(1.12);
    });
    stage.addEventListener("mouseleave", () => {
        targetSpeed = reducedMotion.matches ? 0 : 0.28;
        setHoverScale(1);
    });
    stage.addEventListener("focusin", () => {
        targetSpeed = 0.65;
        setHoverScale(1.12);
    });
    stage.addEventListener("focusout", () => {
        targetSpeed = reducedMotion.matches ? 0 : 0.28;
        setHoverScale(1);
    });
    stage.addEventListener("click", () => {
        window.location.href = stageLink;
    });
    stage.addEventListener("keydown", (event) => {
        if (event.key === "Enter" || event.key === " ") {
            event.preventDefault();
            window.location.href = stageLink;
        }
    });
    reducedMotion.addEventListener("change", () => {
        targetSpeed = reducedMotion.matches ? 0 : 0.28;
        if (reducedMotion.matches) {
            setHoverScale(1);
        }
    });

    requestAnimationFrame(animate);
}
