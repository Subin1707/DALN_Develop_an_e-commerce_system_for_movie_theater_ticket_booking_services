@push('styles')
<style>
    .showtime-form-page {
        display: grid;
        gap: 22px;
    }

    .showtime-form-hero,
    .showtime-form-panel {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .showtime-form-hero {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 26px;
        background:
            linear-gradient(135deg, rgba(233,69,96,.16), rgba(15,23,42,.98) 45%, rgba(17,24,39,.98)),
            radial-gradient(circle at top right, rgba(250,204,21,.13), transparent 34%);
    }

    .showtime-form-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 68px;
        height: 68px;
        flex: 0 0 68px;
        border-radius: 8px;
        background: #e94560;
        color: #fff;
        font-size: 1.75rem;
        box-shadow: 0 14px 30px rgba(233,69,96,.3);
    }

    .showtime-form-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .showtime-form-hero h1 {
        margin: 6px 0 6px;
        color: #fff;
        font-size: 2rem;
        font-weight: 900;
    }

    .showtime-form-hero p {
        margin: 0;
        color: #cbd5e1;
        font-size: 1rem;
    }

    .showtime-form-panel {
        padding: 24px;
    }

    .showtime-form-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 22px;
        align-items: start;
    }

    .showtime-form-main {
        display: grid;
        gap: 16px;
    }

    .showtime-form-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .showtime-field,
    .showtime-summary {
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 8px;
        background: rgba(255,255,255,.035);
    }

    .showtime-field {
        padding: 16px;
    }

    .showtime-field .form-label {
        color: #e5e7eb;
        font-weight: 900;
        margin-bottom: 8px;
    }

    .showtime-field .form-control,
    .showtime-field .form-select,
    .showtime-input-group .input-group-text {
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 8px;
        background-color: #111827;
        color: #fff;
    }

    .showtime-field .form-control,
    .showtime-field .form-select {
        min-height: 46px;
    }

    .showtime-input-group .form-control {
        border-radius: 8px 0 0 8px;
    }

    .showtime-input-group .input-group-text {
        border-left: 0;
        border-radius: 0 8px 8px 0;
        color: #facc15;
        font-weight: 900;
    }

    .showtime-field .form-control:focus,
    .showtime-field .form-select:focus {
        border-color: #e94560;
        box-shadow: 0 0 0 .18rem rgba(233,69,96,.12);
        background-color: #111827;
        color: #fff;
    }

    .field-hint {
        display: block;
        margin-top: 8px;
        color: #94a3b8;
        line-height: 1.4;
    }

    .showtime-summary {
        position: sticky;
        top: 90px;
        padding: 20px;
        background:
            linear-gradient(180deg, rgba(233,69,96,.12), rgba(17,24,39,.82)),
            #111827;
    }

    .summary-kicker {
        color: #facc15;
        font-size: .72rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .showtime-summary h2 {
        margin: 8px 0 16px;
        color: #fff;
        font-size: 1.35rem;
        font-weight: 900;
    }

    .summary-list {
        display: grid;
        gap: 10px;
        margin-bottom: 16px;
    }

    .summary-list div {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 42px;
        padding: 10px 12px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 8px;
        background: rgba(15,23,42,.72);
        color: #e5e7eb;
    }

    .summary-list i {
        color: #e94560;
    }

    .showtime-summary p {
        margin: 0;
        color: #94a3b8;
        line-height: 1.5;
    }

    .showtime-alert {
        border: 1px solid rgba(239,68,68,.35);
        border-radius: 8px;
        background: rgba(127,29,29,.22);
        color: #fecaca;
    }

    .showtime-form-actions {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid rgba(255,255,255,.08);
    }

    .showtime-form-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        border-radius: 8px;
        font-weight: 900;
        padding-inline: 18px;
    }

    @media (max-width: 991.98px) {
        .showtime-form-layout {
            grid-template-columns: 1fr;
        }

        .showtime-summary {
            position: static;
        }
    }

    @media (max-width: 767.98px) {
        .showtime-form-hero {
            align-items: flex-start;
            flex-direction: column;
        }

        .showtime-form-row {
            grid-template-columns: 1fr;
        }

        .showtime-form-actions {
            flex-direction: column;
        }
    }
</style>
@endpush
