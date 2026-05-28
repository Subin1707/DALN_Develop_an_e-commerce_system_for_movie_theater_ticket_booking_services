@push('styles')
<style>
    .room-form-page {
        display: grid;
        gap: 22px;
    }

    .room-form-hero,
    .room-form-panel {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .room-form-hero {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 26px;
        background:
            linear-gradient(135deg, rgba(233,69,96,.16), rgba(15,23,42,.98) 45%, rgba(17,24,39,.98)),
            radial-gradient(circle at top right, rgba(250,204,21,.12), transparent 34%);
    }

    .room-form-icon {
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

    .room-form-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .room-form-hero h1 {
        margin: 6px 0 6px;
        color: #fff;
        font-size: 2rem;
        font-weight: 900;
    }

    .room-form-hero p {
        margin: 0;
        color: #cbd5e1;
        font-size: 1rem;
    }

    .room-form-panel {
        padding: 24px;
    }

    .room-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .room-field-wide {
        grid-column: 1 / -1;
    }

    .room-field {
        padding: 16px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 8px;
        background: rgba(255,255,255,.035);
    }

    .room-field .form-label {
        color: #e5e7eb;
        font-weight: 900;
        margin-bottom: 8px;
    }

    .room-field .form-control,
    .room-field .form-select {
        min-height: 46px;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 8px;
        background-color: #111827;
        color: #fff;
    }

    .room-field .form-control:focus,
    .room-field .form-select:focus {
        border-color: #e94560;
        box-shadow: 0 0 0 .18rem rgba(233,69,96,.12);
        background-color: #111827;
        color: #fff;
    }

    .room-form-actions {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid rgba(255,255,255,.08);
    }

    .room-form-btn {
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
        .room-form-hero {
            align-items: flex-start;
            flex-direction: column;
        }

        .room-form-grid {
            grid-template-columns: 1fr;
        }

        .room-form-actions {
            flex-direction: column;
        }
    }
</style>
@endpush
