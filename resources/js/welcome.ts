import * as THREE from 'three';
import axios from 'axios';

interface TootTile {
    mesh: THREE.Mesh;
    row: number;
    col: number;
    targetOpacity: number;
    currentOpacity: number;
    tootIndex: number;
}

// 調整可能な設定値
const CONFIG = {
    // タイル切り替え間隔（秒）
    TILE_CHANGE_INTERVAL: 10,
    // 初回表示の遅延（ミリ秒）
    INITIAL_DELAY: 100,
    // フェードアニメーション速度
    FADE_SPEED: 0.03,
    // タイルの間隔
    TILE_GAP: 0.3,
};

class WelcomeScene {
    private scene: THREE.Scene;
    private camera: THREE.PerspectiveCamera;
    private renderer: THREE.WebGLRenderer;
    private tootTiles: TootTile[] = [];
    private allToots: string[] = [];
    private clock: THREE.Clock;
    private mouse: THREE.Vector2 = new THREE.Vector2();
    private targetRotation: THREE.Vector2 = new THREE.Vector2();
    private tileLayout: { cols: number; rows: number; tileWidth: number; tileHeight: number } | null = null;
    private lastChangeTime: number = 0;
    private initialAnimationComplete: boolean = false;
    private currentTileIndex: number = 0;

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
            this.allToots = response.data;

            const loadingEl = document.getElementById('welcome-loading');
            if (loadingEl) {
                loadingEl.style.opacity = '0';
                setTimeout(() => loadingEl.remove(), 500);
            }

            this.createTileLayout();
        } catch (error) {
            console.error('Failed to load toots:', error);
            const loadingEl = document.getElementById('welcome-loading');
            if (loadingEl) {
                loadingEl.innerHTML = '<span style="color: #f87171;">Failed to load</span>';
            }
        }
    }

    private calculateTileLayout(): { cols: number; rows: number; tileWidth: number; tileHeight: number } {
        const fov = this.camera.fov * (Math.PI / 180);
        const distance = this.camera.position.z;
        const visibleHeight = 2 * Math.tan(fov / 2) * distance;
        const visibleWidth = visibleHeight * this.camera.aspect;

        const tileAspect = 4;
        const targetTileWidth = 10;
        const tileWidth = targetTileWidth;
        const tileHeight = tileWidth / tileAspect;

        const cols = Math.floor(visibleWidth / (tileWidth + CONFIG.TILE_GAP));
        const rows = Math.floor(visibleHeight / (tileHeight + CONFIG.TILE_GAP));

        return { cols, rows, tileWidth, tileHeight };
    }

    private createTileLayout(): void {
        this.tileLayout = this.calculateTileLayout();
        const { cols, rows, tileWidth, tileHeight } = this.tileLayout;

        const totalWidth = cols * tileWidth + (cols - 1) * CONFIG.TILE_GAP;
        const totalHeight = rows * tileHeight + (rows - 1) * CONFIG.TILE_GAP;
        const startX = -totalWidth / 2 + tileWidth / 2;
        const startY = totalHeight / 2 - tileHeight / 2;

        let tootIndex = 0;
        let tileIndex = 0;

        for (let row = 0; row < rows; row++) {
            for (let col = 0; col < cols; col++) {
                const toot = this.allToots[tootIndex % this.allToots.length];
                const mesh = this.createTileMesh(toot, tileWidth, tileHeight);

                mesh.position.x = startX + col * (tileWidth + CONFIG.TILE_GAP);
                mesh.position.y = startY - row * (tileHeight + CONFIG.TILE_GAP);
                mesh.position.z = -5;

                (mesh.material as THREE.MeshBasicMaterial).opacity = 0;

                this.scene.add(mesh);

                const currentTileIndex = tileIndex;

                this.tootTiles.push({
                    mesh,
                    row,
                    col,
                    targetOpacity: 0,
                    currentOpacity: 0,
                    tootIndex
                });

                setTimeout(() => {
                    const tile = this.tootTiles[currentTileIndex];
                    if (tile) {
                        tile.targetOpacity = 0.85;
                    }
                }, CONFIG.INITIAL_DELAY * currentTileIndex);

                tootIndex++;
                tileIndex++;
            }
        }

        setTimeout(() => {
            this.initialAnimationComplete = true;
            this.lastChangeTime = this.clock.getElapsedTime();
        }, CONFIG.INITIAL_DELAY * tileIndex + 500);
    }

    private createTileMesh(toot: string, width: number, height: number): THREE.Mesh {
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
            opacity: 0.85,
            side: THREE.DoubleSide
        });

        const geometry = new THREE.PlaneGeometry(width, height);
        return new THREE.Mesh(geometry, material);
    }

    private updateTileContent(tile: TootTile, newTootIndex: number): void {
        const toot = this.allToots[newTootIndex % this.allToots.length];
        const { tileWidth, tileHeight } = this.tileLayout!;

        const oldMesh = tile.mesh;
        const newMesh = this.createTileMesh(toot, tileWidth, tileHeight);

        newMesh.position.copy(oldMesh.position);
        (newMesh.material as THREE.MeshBasicMaterial).opacity = 0;

        this.scene.remove(oldMesh);
        oldMesh.geometry.dispose();
        (oldMesh.material as THREE.MeshBasicMaterial).dispose();

        this.scene.add(newMesh);
        tile.mesh = newMesh;
        tile.tootIndex = newTootIndex;
        tile.currentOpacity = 0;
        tile.targetOpacity = 0.85;
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

        this.targetRotation.x = this.mouse.y * 0.03;
        this.targetRotation.y = this.mouse.x * 0.03;

        this.camera.rotation.x += (this.targetRotation.x - this.camera.rotation.x) * 0.02;
        this.camera.rotation.y += (this.targetRotation.y - this.camera.rotation.y) * 0.02;

        this.tootTiles.forEach((tile) => {
            if (tile.currentOpacity !== tile.targetOpacity) {
                const diff = tile.targetOpacity - tile.currentOpacity;
                tile.currentOpacity += diff * CONFIG.FADE_SPEED;

                if (Math.abs(diff) < 0.01) {
                    tile.currentOpacity = tile.targetOpacity;
                }

                (tile.mesh.material as THREE.MeshBasicMaterial).opacity = tile.currentOpacity;
            }
        });

        if (this.initialAnimationComplete && this.tootTiles.length > 0) {
            if (elapsed - this.lastChangeTime >= CONFIG.TILE_CHANGE_INTERVAL) {
                const tileToChange = this.tootTiles[this.currentTileIndex % this.tootTiles.length];
                const newTootIndex = tileToChange.tootIndex + this.tootTiles.length;
                this.updateTileContent(tileToChange, newTootIndex);

                this.currentTileIndex++;
                this.lastChangeTime = elapsed;
            }
        }

        this.renderer.render(this.scene, this.camera);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new WelcomeScene();
});
