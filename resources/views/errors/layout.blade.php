<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">

    <title>@yield('title') - UNMARIS</title>
    <meta name="description" content="@yield('message')">

    <link rel="icon" type="image/png" href="{{ asset('images/logo-unmaris.png') }}">
    <link rel="preload" href="{{ asset('fonts/bricolage-grotesque-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('fonts/public-sans-latin.woff2') }}" as="font" type="font/woff2" crossorigin>

    <script>
        (function () {
            try {
                var tema = localStorage.getItem('unmaris-theme');
                if (tema === 'dark' || tema === 'light') {
                    document.documentElement.setAttribute('data-theme', tema);
                }
            } catch (e) {}
        })();
    </script>

    <style>
        @font-face {
            font-family: "Bricolage Grotesque";
            src: url("{{ asset('fonts/bricolage-grotesque-latin.woff2') }}") format("woff2");
            font-weight: 200 800;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: "Public Sans";
            src: url("{{ asset('fonts/public-sans-latin.woff2') }}") format("woff2");
            font-weight: 100 900;
            font-style: normal;
            font-display: swap;
        }

        :root {
            --canvas: #fbf7ec;
            --surface: #ffffff;
            --surface-2: #f4eeda;
            --ink: #1b0f52;
            --body: #4b4668;
            --muted: #6f6a86;
            --line: #e6dfc8;
            --line-strong: #d3c9a8;
            --navy: #28166f;
            --navy-deep: #1b0f52;
            --panel: #1b0f52;
            --yellow: #f5d900;
            --yellow-deep: #e2c800;
            --ring: #28166f;
            --shadow: 0 24px 60px -32px rgb(27 15 82 / 0.35);
        }

        @media (prefers-color-scheme: dark) {
            :root:not([data-theme="light"]) {
                --canvas: #0b0a18;
                --surface: #141129;
                --surface-2: #1c1836;
                --ink: #f7f5ff;
                --body: #c3bedc;
                --muted: #9c96b8;
                --line: #2b2650;
                --line-strong: #3d3768;
                --navy: #b7a8ff;
                --navy-deep: #d8cfff;
                --panel: #171236;
                --ring: #f5d900;
                --shadow: 0 24px 60px -32px rgb(0 0 0 / 0.75);
            }
        }

        :root[data-theme="dark"] {
            --canvas: #0b0a18;
            --surface: #141129;
            --surface-2: #1c1836;
            --ink: #f7f5ff;
            --body: #c3bedc;
            --muted: #9c96b8;
            --line: #2b2650;
            --line-strong: #3d3768;
            --navy: #b7a8ff;
            --navy-deep: #d8cfff;
            --panel: #171236;
            --ring: #f5d900;
            --shadow: 0 24px 60px -32px rgb(0 0 0 / 0.75);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            -webkit-text-size-adjust: 100%;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--canvas);
            color: var(--body);
            font-family: "Public Sans", ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
        }

        img {
            display: block;
            max-width: 100%;
            height: auto;
        }

        .skip-link {
            position: absolute;
            left: -9999px;
            top: 0;
            z-index: 100;
            padding: 0.75rem 1rem;
            border-radius: 0 0 0.75rem 0;
            background: var(--yellow);
            color: #1b0f52;
            font-weight: 700;
        }

        .skip-link:focus {
            left: 0;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--line);
            background: var(--surface);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            text-decoration: none;
            min-height: 44px;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .brand-name {
            display: block;
            font-family: "Bricolage Grotesque", "Public Sans", system-ui, sans-serif;
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            line-height: 1.1;
            color: var(--ink);
        }

        .brand-sub {
            display: block;
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
            white-space: nowrap;
        }

        .topbar-link {
            display: inline-flex;
            align-items: center;
            min-height: 44px;
            padding: 0 0.7rem;
            border-radius: 999px;
            border: 1px solid var(--line-strong);
            font-size: 0.72rem;
            font-weight: 700;
            white-space: nowrap;
            text-decoration: none;
            color: var(--ink);
        }

        .topbar-link:hover {
            border-color: var(--navy);
            color: var(--navy);
        }

        .wrap {
            position: relative;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(2rem, 6vw, 4.5rem) 1.25rem;
            overflow: hidden;
        }

        .wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: radial-gradient(var(--line-strong) 1px, transparent 1px);
            background-size: 26px 26px;
            opacity: 0.55;
            pointer-events: none;
        }

        .deco {
            position: absolute;
            width: clamp(240px, 38vw, 460px);
            height: clamp(240px, 38vw, 460px);
            right: clamp(-160px, -10vw, -60px);
            top: clamp(-140px, -8vw, -50px);
            border-radius: 50%;
            background: var(--yellow);
            opacity: 0.85;
            pointer-events: none;
        }

        .deco::after {
            content: "";
            position: absolute;
            inset: 18%;
            border-radius: 50%;
            border: 2px solid rgb(27 15 82 / 0.16);
        }

        .card {
            position: relative;
            z-index: 1;
            display: grid;
            gap: 0;
            width: min(100%, 980px);
            border: 1px solid var(--line);
            border-radius: 2rem;
            background: var(--surface);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        @media (min-width: 820px) {
            .card {
                grid-template-columns: 0.85fr 1.15fr;
            }
        }

        .code-panel {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 1.5rem;
            padding: 1.75rem;
            background: var(--panel);
            color: #f5d900;
            border-bottom: 4px solid var(--yellow);
        }

        @media (min-width: 820px) {
            .code-panel {
                border-bottom: 0;
                border-right: 4px solid var(--yellow);
                padding: 2.25rem;
            }
        }

        .code {
            font-family: "Bricolage Grotesque", "Public Sans", system-ui, sans-serif;
            font-size: clamp(3.5rem, 12vw, 6.5rem);
            font-weight: 800;
            line-height: 0.9;
            letter-spacing: -0.04em;
            color: var(--yellow);
        }

        .code-label {
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgb(255 255 255 / 0.6);
        }

        .content {
            padding: 1.75rem;
        }

        @media (min-width: 640px) {
            .content {
                padding: 2.5rem;
            }
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0 0 0.9rem;
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--navy);
        }

        .eyebrow::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--yellow);
            box-shadow: 0 0 0 3px rgb(245 217 0 / 0.25);
        }

        h1 {
            margin: 0;
            font-family: "Bricolage Grotesque", "Public Sans", system-ui, sans-serif;
            font-size: clamp(1.85rem, 4.2vw, 2.75rem);
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -0.02em;
            color: var(--ink);
            text-wrap: balance;
        }

        .message {
            margin: 1rem 0 0;
            font-size: 0.95rem;
            line-height: 1.75;
            color: var(--body);
            max-width: 46ch;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.7rem;
            margin-top: 1.75rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            min-height: 46px;
            padding: 0 1.4rem;
            border-radius: 999px;
            border: 1px solid transparent;
            font-size: 0.85rem;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 160ms ease, color 160ms ease, border-color 160ms ease;
        }

        .btn-primary {
            background: var(--yellow);
            color: #1b0f52;
        }

        .btn-primary:hover {
            background: var(--yellow-deep);
        }

        .btn-outline {
            background: transparent;
            border-color: var(--line-strong);
            color: var(--ink);
        }

        .btn-outline:hover {
            border-color: var(--navy);
            color: var(--navy);
        }

        .btn svg {
            width: 1rem;
            height: 1rem;
            flex-shrink: 0;
        }

        .hint {
            margin: 1.5rem 0 0;
            padding-top: 1.1rem;
            border-top: 1px solid var(--line);
            font-size: 0.75rem;
            line-height: 1.7;
            color: var(--muted);
        }

        .footer {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            padding: 1.1rem 1.25rem 1.4rem;
            border-top: 1px solid var(--line);
            background: var(--surface);
            font-size: 0.72rem;
            color: var(--muted);
        }

        @media (min-width: 640px) {
            .footer {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        .footer a {
            font-weight: 700;
            color: var(--navy);
        }

        :focus-visible {
            outline: 3px solid var(--ring);
            outline-offset: 3px;
        }

        .code-panel :focus-visible {
            outline-color: var(--yellow);
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                transition-duration: 0.01ms !important;
                animation-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>
    <a class="skip-link" href="#konten-utama">Lewati ke konten utama</a>

    <header class="topbar">
        <a class="brand" href="{{ url('/') }}" aria-label="UNMARIS — kembali ke beranda">
            <img class="brand-logo" src="{{ asset('images/logo-unmaris.png') }}" alt="" width="40" height="40" decoding="async">
            <span>
                <span class="brand-name">UNMARIS</span>
                <span class="brand-sub">Stella Maris Sumba</span>
            </span>
        </a>

        <a class="topbar-link" href="{{ url('/kontak') }}">Hubungi Kami</a>
    </header>

    <main class="wrap" id="konten-utama">
        <div class="deco" aria-hidden="true"></div>

        <div class="card">
            <div class="code-panel">
                <span class="code" aria-hidden="true">@yield('code')</span>
                <span class="code-label">Kode Kesalahan @yield('code')</span>
            </div>

            <div class="content">
                <p class="eyebrow">@yield('eyebrow')</p>
                <h1>@yield('heading')</h1>
                <p class="message">@yield('message')</p>

                <div class="actions">
                    @hasSection('actions')
                        @yield('actions')
                    @else
                        <a class="btn btn-primary" href="{{ url('/') }}">
                            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Beranda
                        </a>
                        <a class="btn btn-outline" href="{{ url('/kontak') }}">Hubungi Kami</a>
                    @endif
                </div>

                <p class="hint">@yield('hint', 'Jika masalah ini terus terjadi, silakan hubungi administrator situs melalui halaman kontak resmi UNMARIS.')</p>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Universitas Stella Maris Sumba. Hak cipta dilindungi.</p>
        <p>Butuh bantuan? <a href="{{ url('/kontak') }}">Hubungi kami</a>.</p>
    </footer>
</body>
</html>
