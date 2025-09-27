<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Verify Email</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />

    <link rel="shortcut icon" href="#">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Exo+2:wght@400;700&display=swap');
        body {
            font-family: 'Exo 2', 'Exo 2 Fallback', sans-serif;
            background-color: #f7f8fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        .bg-primary-predik {
            background-color: #0e69a0;
        }
        .btn-primary-predik,
        .btn-primary-predik:hover {
            background-color: #0e69a0;
            color: white;
        }
    </style>
</head>
<body class="bg-light">
<canvas class="fireworks position-fixed top-0 start-0 w-100 h-100"></canvas>

<div class="container h-100">
    <div class="row h-100 align-items-center justify-content-center">
        <div class="col-12 col-lg-3 p-5 p-lg-0">
            <div class="card shadow border-0">
                <div class="card-header bg-primary-predik text-center text-white p-4">
                    <p class="mb-0" style="font-size: 5rem;">
                        <i class="fa-regular fa-circle-check"></i>
                    </p>
                    SUCCESS
                </div>
                <div class="card-body text-center p-4">
                    <p class="text-secondary mb-0 fs-6">
                        Congratulation, your account has been successfully created.
                    </p>

                    <p class="text-center mt-4">
                        <a href="{{ env('APP_FE_URL') }}/login" class="btn btn-primary-predik rounded-pill py-1 px-4 shadow-sm">OPEN</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

<script>
    const canvas = document.querySelector(".fireworks");
    const ctx = canvas.getContext("2d");
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    function createFirework(x, y) {
        const particles = [];
        for (let i = 0; i < 30; i++) {
            particles.push({
                x, y,
                angle: (Math.PI * 2 * i) / 30,
                speed: Math.random() * 3 + 2,
                radius: Math.random() * 3 + 2,
                opacity: 1
            });
        }
        return particles;
    }

    let fireworks = [];
    setInterval(() => {
        fireworks.push(createFirework(Math.random() * canvas.width, Math.random() * canvas.height * 0.5));
    }, 500);

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        fireworks.forEach((firework, index) => {
            firework.forEach(p => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(${Math.random()*255}, ${Math.random()*255}, ${Math.random()*255}, ${p.opacity})`;
                ctx.fill();
                p.x += Math.cos(p.angle) * p.speed;
                p.y += Math.sin(p.angle) * p.speed;
                p.opacity -= 0.02;
            });
            fireworks[index] = firework.filter(p => p.opacity > 0);
        });
        fireworks = fireworks.filter(f => f.length > 0);
        requestAnimationFrame(animate);
    }
    animate();
</script>
</body>
</html>
