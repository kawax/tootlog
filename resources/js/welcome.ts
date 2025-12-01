import * as THREE from 'three';
import axios from 'axios';

interface TootSprite {
    mesh: THREE.Mesh;
    speed: number;
    amplitude: number;
    phase: number;
}

class WelcomeScene {
    private scene: THREE.Scene;
    private camera: THREE.PerspectiveCamera;
    private renderer: THREE.WebGLRenderer;
    private tootSprites: TootSprite[] = [];
    private clock: THREE.Clock;
    private mouse: THREE.Vector2 = new THREE.Vector2();
    private targetRotation: THREE.Vector2 = new THREE.Vector2();

    constructor() {
        this.scene = new THREE.Scene();
        this.clock = new THREE.Clock();

        const canvas = document.getElementById('welcome-canvas') as HTMLCanvasElement;
        this.camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
        this.camera.position.z = 30;

        this.renderer = new THREE.WebGLRenderer({
            canvas,
            antialias: true,
            alpha: true
        });
        this.renderer.setSize(window.innerWidth, window.innerHeight);
        this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        this.renderer.setClearColor(0x0a0a0f, 1);

        this.addLights();
        this.addParticles();

        window.addEventListener('resize', () => this.onResize());
        window.addEventListener('mousemove', (e) => this.onMouseMove(e));

        this.loadToots();
        this.animate();
    }

    private addLights(): void {
        const ambientLight = new THREE.AmbientLight(0x6366f1, 0.3);
        this.scene.add(ambientLight);

        const pointLight1 = new THREE.PointLight(0xa855f7, 1, 100);
        pointLight1.position.set(20, 20, 20);
        this.scene.add(pointLight1);

        const pointLight2 = new THREE.PointLight(0x22d3ee, 0.8, 100);
        pointLight2.position.set(-20, -20, 10);
        this.scene.add(pointLight2);
    }

    private addParticles(): void {
        const particleCount = 200;
        const geometry = new THREE.BufferGeometry();
        const positions = new Float32Array(particleCount * 3);

        for (let i = 0; i < particleCount * 3; i += 3) {
            positions[i] = (Math.random() - 0.5) * 100;
            positions[i + 1] = (Math.random() - 0.5) * 100;
            positions[i + 2] = (Math.random() - 0.5) * 50;
        }

        geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));

        const material = new THREE.PointsMaterial({
            color: 0x6366f1,
            size: 0.1,
            transparent: true,
            opacity: 0.6,
            blending: THREE.AdditiveBlending
        });

        const particles = new THREE.Points(geometry, material);
        this.scene.add(particles);
    }

    private async loadToots(): Promise<void> {
        try {
            const response = await axios.get<string[]>('/api/welcome');
            const toots = response.data;

            const loadingEl = document.getElementById('welcome-loading');
            if (loadingEl) {
                loadingEl.style.opacity = '0';
                setTimeout(() => loadingEl.remove(), 500);
            }

            this.createTootSprites(toots);
        } catch (error) {
            console.error('Failed to load toots:', error);
            const loadingEl = document.getElementById('welcome-loading');
            if (loadingEl) {
                loadingEl.innerHTML = '<span style="color: #f87171;">Failed to load</span>';
            }
        }
    }

    private createTootSprites(toots: string[]): void {
        const colors = [0x6366f1, 0xa855f7, 0x22d3ee, 0x818cf8, 0xc084fc];

        toots.forEach((toot, index) => {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d')!;

            canvas.width = 512;
            canvas.height = 128;

            context.fillStyle = `rgba(${Math.random() * 30 + 10}, ${Math.random() * 30 + 10}, ${Math.random() * 40 + 20}, 0.85)`;
            this.roundRect(context, 0, 0, canvas.width, canvas.height, 12);
            context.fill();

            const gradient = context.createLinearGradient(0, 0, canvas.width, 0);
            gradient.addColorStop(0, `rgba(99, 102, 241, 0.3)`);
            gradient.addColorStop(1, `rgba(168, 85, 247, 0.1)`);
            context.strokeStyle = gradient;
            context.lineWidth = 2;
            this.roundRect(context, 1, 1, canvas.width - 2, canvas.height - 2, 12);
            context.stroke();

            context.fillStyle = '#e2e8f0';
            context.font = '20px "Space Mono", monospace';
            context.textAlign = 'left';
            context.textBaseline = 'middle';

            const truncatedText = toot.length > 40 ? toot.substring(0, 40) + '...' : toot;
            context.fillText(truncatedText, 20, canvas.height / 2);

            const texture = new THREE.CanvasTexture(canvas);
            texture.needsUpdate = true;

            const material = new THREE.MeshBasicMaterial({
                map: texture,
                transparent: true,
                opacity: 0.9,
                side: THREE.DoubleSide
            });

            const geometry = new THREE.PlaneGeometry(12, 3);
            const mesh = new THREE.Mesh(geometry, material);

            const row = index % 8;
            const spacing = 60 / 8;
            mesh.position.x = 50 + (index * 15);
            mesh.position.y = -30 + (row * spacing) + (Math.random() - 0.5) * 4;
            mesh.position.z = (Math.random() - 0.5) * 20;

            mesh.rotation.y = (Math.random() - 0.5) * 0.3;
            mesh.rotation.x = (Math.random() - 0.5) * 0.1;

            this.scene.add(mesh);

            this.tootSprites.push({
                mesh,
                speed: 0.02 + Math.random() * 0.03,
                amplitude: 0.5 + Math.random() * 1,
                phase: Math.random() * Math.PI * 2
            });
        });
    }

    private roundRect(ctx: CanvasRenderingContext2D, x: number, y: number, w: number, h: number, r: number): void {
        ctx.beginPath();
        ctx.moveTo(x + r, y);
        ctx.lineTo(x + w - r, y);
        ctx.quadraticCurveTo(x + w, y, x + w, y + r);
        ctx.lineTo(x + w, y + h - r);
        ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
        ctx.lineTo(x + r, y + h);
        ctx.quadraticCurveTo(x, y + h, x, y + h - r);
        ctx.lineTo(x, y + r);
        ctx.quadraticCurveTo(x, y, x + r, y);
        ctx.closePath();
    }

    private onResize(): void {
        this.camera.aspect = window.innerWidth / window.innerHeight;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(window.innerWidth, window.innerHeight);
    }

    private onMouseMove(event: MouseEvent): void {
        this.mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        this.mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
    }

    private animate(): void {
        requestAnimationFrame(() => this.animate());

        const elapsed = this.clock.getElapsedTime();

        this.targetRotation.x = this.mouse.y * 0.05;
        this.targetRotation.y = this.mouse.x * 0.05;

        this.camera.rotation.x += (this.targetRotation.x - this.camera.rotation.x) * 0.02;
        this.camera.rotation.y += (this.targetRotation.y - this.camera.rotation.y) * 0.02;

        this.tootSprites.forEach((sprite) => {
            sprite.mesh.position.x -= sprite.speed * 60;

            sprite.mesh.position.y += Math.sin(elapsed * 0.5 + sprite.phase) * 0.01 * sprite.amplitude;

            if (sprite.mesh.position.x < -60) {
                sprite.mesh.position.x = 60 + Math.random() * 20;
            }
        });

        this.renderer.render(this.scene, this.camera);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new WelcomeScene();
});
