import * as THREE from 'three';

/**
 * Interactive 3D Architectural Living Sculpture for Rime Interior Hero.
 * Gracefully degrades on prefers-reduced-motion or low-capability devices.
 */
export function initHero3D(containerId = 'hero-3d-canvas') {
    const container = document.getElementById(containerId);
    if (!container) return null;

    // Respect reduced motion & low-end hardware gracefully
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        container.dataset.degraded = 'reduced-motion';
        return null;
    }

    const isSmallScreen = window.innerWidth < 768;
    const lowCores = typeof navigator.hardwareConcurrency === 'number' && navigator.hardwareConcurrency <= 2;

    let renderer;
    try {
        renderer = new THREE.WebGLRenderer({
            antialias: !isSmallScreen,
            alpha: true,
            powerPreference: isSmallScreen ? 'low-power' : 'high-performance',
        });
    } catch {
        container.dataset.degraded = 'no-webgl';
        return null;
    }

    const width = container.clientWidth || window.innerWidth;
    const height = container.clientHeight || window.innerHeight;

    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, isSmallScreen || lowCores ? 1.25 : 2));
    renderer.setSize(width, height);
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.15;

    container.innerHTML = '';
    container.appendChild(renderer.domElement);

    const scene = new THREE.Scene();

    const camera = new THREE.PerspectiveCamera(42, width / height, 0.1, 100);
    camera.position.set(0, 1.4, isSmallScreen ? 8.5 : 6.8);

    // Luxury Studio Lighting (warm champagne gold + soft sage/cool fill)
    const ambientLight = new THREE.AmbientLight(0xf8f5f0, 0.65);
    scene.add(ambientLight);

    const goldKeyLight = new THREE.DirectionalLight(0xffdfb3, 2.2);
    goldKeyLight.position.set(5, 7, 5);
    scene.add(goldKeyLight);

    const rimLight = new THREE.PointLight(0x8a9a86, 2.4, 20);
    rimLight.position.set(-5, 3, -3);
    scene.add(rimLight);

    const warmPendantLight = new THREE.PointLight(0xcf9d5d, 3.0, 16);
    warmPendantLight.position.set(1.4, 3.2, 2.0);
    scene.add(warmPendantLight);

    // Master floating architectural vignette group
    const vignette = new THREE.Group();
    vignette.position.set(isSmallScreen ? 0 : 1.55, -0.35, 0);
    scene.add(vignette);

    // Materials
    const marbleMat = new THREE.MeshStandardMaterial({
        color: 0xf4efe6,
        roughness: 0.25,
        metalness: 0.08,
    });

    const charcoalMat = new THREE.MeshStandardMaterial({
        color: 0x242424,
        roughness: 0.55,
        metalness: 0.15,
    });

    const brassMat = new THREE.MeshStandardMaterial({
        color: 0xc59353,
        roughness: 0.22,
        metalness: 0.88,
    });

    const sageVelvetMat = new THREE.MeshStandardMaterial({
        color: 0x8a9a86,
        roughness: 0.78,
        metalness: 0.05,
    });

    // 1. Floating Architectural Plinth
    const plinth = new THREE.Mesh(new THREE.CylinderGeometry(2.3, 2.45, 0.18, 48), charcoalMat);
    plinth.position.y = -0.95;
    vignette.add(plinth);

    const brassRim = new THREE.Mesh(new THREE.TorusGeometry(2.32, 0.025, 16, 64), brassMat);
    brassRim.rotation.x = Math.PI / 2;
    brassRim.position.y = -0.86;
    vignette.add(brassRim);

    // 2. Sculptural Lounge Sofa / Chair Composition
    const loungeGroup = new THREE.Group();
    loungeGroup.position.set(-0.25, -0.35, 0.1);
    loungeGroup.rotation.y = -0.35;

    const seat = new THREE.Mesh(new THREE.BoxGeometry(1.75, 0.34, 0.92), sageVelvetMat);
    seat.position.y = 0;
    loungeGroup.add(seat);

    const backrest = new THREE.Mesh(new THREE.BoxGeometry(1.75, 0.68, 0.22), sageVelvetMat);
    backrest.position.set(0, 0.38, -0.35);
    loungeGroup.add(backrest);

    const leftArm = new THREE.Mesh(new THREE.BoxGeometry(0.2, 0.45, 0.92), sageVelvetMat);
    leftArm.position.set(-0.78, 0.14, 0);
    loungeGroup.add(leftArm);

    const rightArm = new THREE.Mesh(new THREE.BoxGeometry(0.2, 0.45, 0.92), sageVelvetMat);
    rightArm.position.set(0.78, 0.14, 0);
    loungeGroup.add(rightArm);

    // Brass legs
    const legGeo = new THREE.CylinderGeometry(0.03, 0.02, 0.35, 12);
    [[-0.72, -0.34, 0.35], [0.72, -0.34, 0.35], [-0.72, -0.34, -0.35], [0.72, -0.34, -0.35]].forEach(([x, y, z]) => {
        const leg = new THREE.Mesh(legGeo, brassMat);
        leg.position.set(x, y, z);
        loungeGroup.add(leg);
    });

    vignette.add(loungeGroup);

    // 3. Monolithic Marble Coffee Table
    const tableGroup = new THREE.Group();
    tableGroup.position.set(0.55, -0.52, 1.05);

    const tableTop = new THREE.Mesh(new THREE.CylinderGeometry(0.68, 0.68, 0.08, 36), marbleMat);
    tableTop.position.y = 0.22;
    tableGroup.add(tableTop);

    const tablePedestal = new THREE.Mesh(new THREE.CylinderGeometry(0.2, 0.28, 0.56, 24), brassMat);
    tablePedestal.position.y = -0.08;
    tableGroup.add(tablePedestal);

    vignette.add(tableGroup);

    // 4. Floating Architectural Brass Rings & Sculptural Pendant Orb
    const outerOrbit = new THREE.Mesh(new THREE.TorusGeometry(2.65, 0.016, 12, 80), brassMat);
    outerOrbit.rotation.set(Math.PI / 2.6, 0.2, 0);
    outerOrbit.position.y = 0.35;
    vignette.add(outerOrbit);

    const innerOrbit = new THREE.Mesh(new THREE.TorusGeometry(1.95, 0.012, 12, 64), brassMat);
    innerOrbit.rotation.set(-Math.PI / 3.1, -0.3, 0.4);
    innerOrbit.position.y = 0.55;
    vignette.add(innerOrbit);

    const pendantOrb = new THREE.Mesh(
        new THREE.SphereGeometry(0.22, 32, 32),
        new THREE.MeshStandardMaterial({
            color: 0xffecd2,
            emissive: 0xb8894d,
            emissiveIntensity: 0.75,
            roughness: 0.15,
            metalness: 0.3,
        })
    );
    pendantOrb.position.set(0.85, 1.55, 0.45);
    vignette.add(pendantOrb);

    // 5. Floating Ambient Gold Dust Motes
    const particleCount = isSmallScreen || lowCores ? 45 : 110;
    const positions = new Float32Array(particleCount * 3);
    for (let i = 0; i < particleCount; i++) {
        positions[i * 3] = (Math.random() - 0.5) * 10;
        positions[i * 3 + 1] = (Math.random() - 0.5) * 6;
        positions[i * 3 + 2] = (Math.random() - 0.5) * 6;
    }
    const particleGeo = new THREE.BufferGeometry();
    particleGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    const particleMat = new THREE.PointsMaterial({
        color: 0xcf9d5d,
        size: 0.035,
        transparent: true,
        opacity: 0.65,
    });
    const particles = new THREE.Points(particleGeo, particleMat);
    scene.add(particles);

    // Mouse parallax tracking
    const targetPointer = { x: 0, y: 0 };
    const currentPointer = { x: 0, y: 0 };

    const onPointerMove = (e) => {
        const rect = container.getBoundingClientRect();
        targetPointer.x = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
        targetPointer.y = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
    };

    window.addEventListener('pointermove', onPointerMove, { passive: true });

    const onResize = () => {
        if (!container) return;
        const newW = container.clientWidth || window.innerWidth;
        const newH = container.clientHeight || window.innerHeight;
        camera.aspect = newW / newH;
        camera.updateProjectionMatrix();
        renderer.setSize(newW, newH);
    };

    window.addEventListener('resize', onResize);

    // Animation loop
    let animId = null;
    const clock = new THREE.Clock();

    function animate() {
        animId = requestAnimationFrame(animate);
        const t = clock.getElapsedTime();

        currentPointer.x += (targetPointer.x - currentPointer.x) * 0.05;
        currentPointer.y += (targetPointer.y - currentPointer.y) * 0.05;

        vignette.rotation.y = Math.sin(t * 0.25) * 0.22 + currentPointer.x * 0.35;
        vignette.rotation.x = currentPointer.y * 0.12;
        vignette.position.y = -0.35 + Math.sin(t * 0.7) * 0.08;

        outerOrbit.rotation.z = t * 0.14;
        innerOrbit.rotation.z = -t * 0.18;
        pendantOrb.position.y = 1.55 + Math.sin(t * 1.1) * 0.1;

        particles.rotation.y = t * 0.03;

        renderer.render(scene, camera);
    }

    animate();

    return () => {
        if (animId) cancelAnimationFrame(animId);
        window.removeEventListener('pointermove', onPointerMove);
        window.removeEventListener('resize', onResize);
        renderer.dispose();
    };
}

