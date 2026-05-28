@push('styles')
<style>
    .movie-form-page {
        display: grid;
        gap: 22px;
    }

    .movie-form-hero,
    .movie-form-panel {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .movie-form-hero {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 26px;
        background:
            linear-gradient(135deg, rgba(233,69,96,.16), rgba(15,23,42,.98) 45%, rgba(17,24,39,.98)),
            radial-gradient(circle at top right, rgba(250,204,21,.12), transparent 34%);
    }

    .movie-form-icon {
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

    .movie-form-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .movie-form-hero h1 {
        margin: 6px 0 6px;
        color: #fff;
        font-size: 2rem;
        font-weight: 900;
    }

    .movie-form-hero p {
        margin: 0;
        color: #cbd5e1;
        font-size: 1rem;
    }

    .movie-form-panel {
        padding: 24px;
    }

    .movie-form-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 330px;
        gap: 22px;
    }

    .movie-form-main,
    .movie-form-side {
        display: grid;
        gap: 16px;
        align-content: start;
    }

    .movie-form-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .movie-field {
        padding: 16px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 8px;
        background: rgba(255,255,255,.035);
    }

    .movie-field .form-label {
        color: #e5e7eb;
        font-weight: 900;
        margin-bottom: 8px;
    }

    .movie-field .form-control,
    .movie-field .form-select,
    .movie-input-group .input-group-text {
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 8px;
        background-color: #111827;
        color: #fff;
    }

    .movie-field .form-control,
    .movie-field .form-select {
        min-height: 46px;
    }

    .movie-input-group .form-control {
        border-radius: 8px 0 0 8px;
    }

    .movie-input-group .input-group-text {
        border-left: 0;
        border-radius: 0 8px 8px 0;
        color: #facc15;
        font-weight: 900;
    }

    .movie-field .form-control:focus,
    .movie-field .form-select:focus {
        border-color: #e94560;
        box-shadow: 0 0 0 .18rem rgba(233,69,96,.12);
        background-color: #111827;
        color: #fff;
    }

    .poster-preview {
        overflow: hidden;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 8px;
        background: #111827;
        aspect-ratio: 2 / 3;
        box-shadow: 0 16px 34px rgba(0,0,0,.28);
    }

    .poster-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .field-hint {
        display: block;
        margin-top: 8px;
        color: #94a3b8;
        line-height: 1.4;
    }

    .movie-form-actions {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid rgba(255,255,255,.08);
    }

    .movie-form-btn {
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
        .movie-form-layout {
            grid-template-columns: 1fr;
        }

        .movie-form-side {
            grid-template-columns: minmax(220px, 300px) minmax(0, 1fr);
            align-items: start;
        }
    }

    @media (max-width: 767.98px) {
        .movie-form-hero,
        .movie-form-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .movie-form-row,
        .movie-form-side {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
