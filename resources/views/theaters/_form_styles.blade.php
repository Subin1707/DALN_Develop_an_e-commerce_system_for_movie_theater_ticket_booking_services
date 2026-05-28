@push('styles')
<style>
    .theater-form-page {
        display: grid;
        gap: 22px;
    }

    .theater-form-hero,
    .theater-form-panel {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .theater-form-hero {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 26px;
        background:
            linear-gradient(135deg, rgba(233,69,96,.16), rgba(15,23,42,.98) 45%, rgba(17,24,39,.98)),
            radial-gradient(circle at top right, rgba(250,204,21,.12), transparent 34%);
    }

    .theater-form-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 68px;
        height: 68px;
        flex: 0 0 68px;
        border-radius: 8px;
        background: #e94560;
        color: #fff;
        font-size: 1.8rem;
        box-shadow: 0 14px 30px rgba(233,69,96,.3);
    }

    .theater-form-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .theater-form-hero h1 {
        margin: 6px 0 6px;
        color: #fff;
        font-size: 2rem;
        font-weight: 900;
    }

    .theater-form-hero p {
        margin: 0;
        color: #cbd5e1;
        font-size: 1rem;
    }

    .theater-form-panel {
        padding: 24px;
    }

    .theater-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .theater-field-wide {
        grid-column: 1 / -1;
    }

    .theater-field {
        padding: 16px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 8px;
        background: rgba(255,255,255,.035);
    }

    .theater-field .form-label {
        color: #e5e7eb;
        font-weight: 900;
        margin-bottom: 8px;
    }

    .theater-field .form-control {
        min-height: 46px;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 8px;
        background-color: #111827;
        color: #fff;
    }

    .theater-field .form-control:focus {
        border-color: #e94560;
        box-shadow: 0 0 0 .18rem rgba(233,69,96,.12);
        background-color: #111827;
        color: #fff;
    }

    .theater-form-actions {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid rgba(255,255,255,.08);
    }

    .theater-form-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        border-radius: 8px;
        font-weight: 900;
        padding-inline: 18px;
    }

    @media (max-width: 767.98px) {
        .theater-form-hero,
        .theater-form-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .theater-form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
