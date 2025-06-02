{{-- resources/views/public/operasional_public.blade.php --}}
@extends('layouts.user') {{-- Sesuaikan dengan nama layout utamamu --}}

@php
    // Helper untuk format jam tanpa detik
    function formatJam(string $jam = null): string {
        if (!$jam) return '-';
        try {
            return \Carbon\Carbon::createFromFormat('H:i:s', $jam)->format('H:i');
        } catch (\Exception $e) {
            try {
                return \Carbon\Carbon::createFromFormat('H:i', $jam)->format('H:i');
            } catch (\Exception $e) {
                return $jam; // Return original if parsing fails
            }
        }
    }
@endphp

@section('title', 'Jadwal Operasional - ' . ($identitasPanti->nama_panti ?? 'Panti Asuhan Rumah Harapan'))

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 50%, #f1f3f4 100%);
        font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
        color: #1a202c;
        line-height: 1.6;
        min-height: 100vh;
        font-size: 15px;
    }

    .operasional-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* Premium Header */
    .page-header-operasional {
        background: linear-gradient(135deg, #1a202c 0%, #2d3748 50%, #4a5568 100%);
        color: white;
        text-align: center;
        padding: 7rem 2rem;
        margin-bottom: 3rem;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(26, 32, 44, 0.1);
    }

    .page-header-operasional::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.02) 50%, transparent 70%);
        animation: shimmer 4s ease-in-out infinite;
    }

    @keyframes shimmer {
        0%, 100% { transform: translateX(-100%); }
        50% { transform: translateX(100%); }
    }

    .page-header-operasional h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        position: relative;
        z-index: 2;
        letter-spacing: -0.025em;
    }

    .page-header-operasional p {
        font-size: 1.25rem;
        opacity: 0.9;
        font-weight: 400;
        position: relative;
        z-index: 2;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Modern Card Section */
    .schedule-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.04);
        margin-bottom: 2rem;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.04);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .schedule-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.08);
    }

    .schedule-card-header {
        background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
        color: white;
        padding: 1.5rem 2rem;
        border-bottom: none;
    }

    .schedule-card-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .schedule-card-body {
        padding: 0;
    }

    /* Modern Schedule Grid */
    .schedule-grid {
        display: grid;
        gap: 0;
    }

    .schedule-row {
        display: grid;
        grid-template-columns: 120px 1fr 120px 1fr;
        align-items: center;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #f7fafc;
        transition: all 0.2s ease;
        position: relative;
    }

    .schedule-row:hover {
        background: linear-gradient(135deg, #f8f9fa 0%, #f1f3f4 100%);
    }

    .schedule-row:last-child {
        border-bottom: none;
    }

    .day-label {
        font-weight: 700;
        color: #1a202c;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        position: relative;
    }

    .day-label::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -4px;
        width: 24px;
        height: 2px;
        background: linear-gradient(90deg, #1a202c, #4a5568);
        border-radius: 1px;
    }

    .time-display {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .time-slot-modern {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-weight: 600;
        font-size: 0.9rem;
        color: #1a202c;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .time-slot-modern::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 3px;
        height: 100%;
        background: linear-gradient(135deg, #1a202c, #4a5568);
        transition: width 0.2s ease;
    }

    .time-slot-modern:hover::before {
        width: 6px;
    }

    .status-display {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border: 2px solid transparent;
        transition: all 0.2s ease;
    }

    .status-open {
        background: #1a202c;
        color: white;
    }

    .status-closed {
        background: #6b7280;
        color: white;
    }

    .status-special {
        background: #f7fafc;
        color: #1a202c;
        border-color: #1a202c;
    }

    .info-text {
        font-size: 0.85rem;
        color: #6b7280;
        font-style: italic;
    }

    /* Special Schedule Card */
    .special-schedule-grid {
        display: grid;
        gap: 1rem;
        padding: 2rem;
    }

    .special-row {
        background: linear-gradient(135deg, #f8f9fa 0%, #f1f3f4 100%);
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .special-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        border-color: #1a202c;
    }

    .special-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .date-badge {
        background: #1a202c;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 100px;
    }

    .date-day {
        font-size: 1.5rem;
        font-weight: 800;
        line-height: 1;
    }

    .date-month {
        font-size: 0.75rem;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .event-title {
        flex: 1;
        min-width: 200px;
    }

    .event-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 0.25rem;
    }

    .event-day {
        font-size: 0.85rem;
        color: #6b7280;
        text-transform: capitalize;
    }

    .special-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .detail-item {
        text-align: center;
        padding: 1rem;
        background: white;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    .detail-label {
        font-size: 0.75rem;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .detail-value {
        font-weight: 600;
        color: #1a202c;
    }

    /* Empty States */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6b7280;
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .operasional-container {
            padding: 1rem;
        }

        .page-header-operasional {
            padding: 3rem 1.5rem;
            margin-bottom: 2rem;
            border-radius: 16px;
        }

        .page-header-operasional h1 {
            font-size: 2.25rem;
        }

        .page-header-operasional p {
            font-size: 1.1rem;
        }

        .schedule-row {
            grid-template-columns: 1fr;
            gap: 1rem;
            padding: 1.25rem 1.5rem;
        }

        .day-label {
            font-size: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 0.5rem;
        }

        .special-header {
            flex-direction: column;
            align-items: stretch;
        }

        .special-details {
            grid-template-columns: 1fr;
        }

        .schedule-card-header {
            padding: 1.25rem 1.5rem;
        }

        .special-schedule-grid {
            padding: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .page-header-operasional h1 {
            font-size: 2rem;
        }

        .schedule-card {
            margin-bottom: 1.5rem;
            border-radius: 12px;
        }

        .special-row {
            padding: 1.25rem;
        }
    }

    /* Smooth animations */
    .fade-in {
        animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(24px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Focus states for accessibility */
    .schedule-row:focus-within {
        outline: 2px solid #1a202c;
        outline-offset: -2px;
    }

    .status-badge:focus {
        outline: 2px solid #1a202c;
        outline-offset: 2px;
    }
</style>
@endpush

@section('content')
<div class="operasional-container">
    <div class="page-header-operasional fade-in">
        <h1>⏰ Jadwal Operasional</h1>
        <p>Informasi lengkap jam buka dan layanan {{ $identitasPanti->nama_panti ?? 'Panti Asuhan Rumah Harapan' }}</p>
    </div>

    {{-- JADWAL OPERASIONAL HARIAN --}}
    <div class="schedule-card fade-in">
        <div class="schedule-card-header">
            <h2>📅 Jadwal Operasional Harian</h2>
        </div>
        <div class="schedule-card-body">
            @forelse($jadwalHarianTampilan as $hari => $slots)
                @if($slots->isNotEmpty())
                    <div class="schedule-row">
                        <div class="day-label">{{ $hari }}</div>
                        <div class="time-display">
                            @foreach($slots as $slot)
                                <div class="time-slot-modern">
                                    {{ formatJam($slot->jam_buka) }} - {{ formatJam($slot->jam_tutup) }}
                                    @if($slot->keterangan)
                                        <div class="info-text">{{ $slot->keterangan }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="status-display">
                            @foreach($slots as $slot)
                                <span class="status-badge {{ $slot->status_operasional == 'Buka' ? 'status-open' : 'status-closed' }}">
                                    {{ $slot->status_operasional }}
                                </span>
                            @endforeach
                        </div>
                        <div class="info-text">
                            Jadwal reguler
                        </div>
                    </div>
                @else
                    <div class="schedule-row">
                        <div class="day-label">{{ $hari }}</div>
                        <div class="info-text" style="grid-column: span 3; text-align: center; padding: 1rem;">
                            Tidak ada jadwal operasional untuk hari ini
                        </div>
                    </div>
                @endif
            @empty
                <div class="empty-state">
                    <div class="empty-state-icon">📅</div>
                    <h3>Belum Ada Jadwal</h3>
                    <p>Jadwal operasional harian belum tersedia</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- JADWAL OPERASIONAL KHUSUS --}}
    <div class="schedule-card fade-in">
        <div class="schedule-card-header">
            <h2>🎉 Jadwal Khusus & Hari Libur</h2>
        </div>
        <div class="schedule-card-body">
            @if($jadwalKhusus->isNotEmpty())
                <div class="special-schedule-grid">
                    @foreach($jadwalKhusus as $khusus)
                        <div class="special-row">
                            <div class="special-header">
                                <div class="date-badge">
                                    <div class="date-day">{{ \Carbon\Carbon::parse($khusus->tanggal)->format('d') }}</div>
                                    <div class="date-month">{{ \Carbon\Carbon::parse($khusus->tanggal)->format('M Y') }}</div>
                                </div>
                                <div class="event-title">
                                    <div class="event-name">{{ $khusus->nama_acara_libur }}</div>
                                    <div class="event-day">{{ \Carbon\Carbon::parse($khusus->tanggal)->isoFormat('dddd') }}</div>
                                </div>
                            </div>
                            
                            <div class="special-details">
                                <div class="detail-item">
                                    <div class="detail-label">Status</div>
                                    <div class="detail-value">
                                        <span class="status-badge {{ $khusus->status_operasional == 'Buka' ? 'status-open' : ($khusus->status_operasional == 'Tutup' ? 'status-closed' : 'status-special') }}">
                                            {{ $khusus->status_operasional }}
                                        </span>
                                    </div>
                                </div>
                                
                                @if($khusus->status_operasional == 'Jam Khusus' && $khusus->jam_buka_khusus && $khusus->jam_tutup_khusus)
                                    <div class="detail-item">
                                        <div class="detail-label">Jam Khusus</div>
                                        <div class="detail-value">
                                            {{ formatJam($khusus->jam_buka_khusus) }} - {{ formatJam($khusus->jam_tutup_khusus) }}
                                        </div>
                                    </div>
                                @endif
                                
                                @if($khusus->keterangan)
                                    <div class="detail-item" style="grid-column: 1 / -1;">
                                        <div class="detail-label">Keterangan</div>
                                        <div class="detail-value">{{ $khusus->keterangan }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">🎉</div>
                    <h3>Tidak Ada Jadwal Khusus</h3>
                    <p>Saat ini tidak ada jadwal khusus atau hari libur.<br>Semua hari mengikuti jadwal operasional reguler.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, observerOptions);

    // Observe all schedule cards
    document.querySelectorAll('.schedule-card').forEach(card => {
        observer.observe(card);
    });

    // Enhanced hover effects for schedule rows
    document.querySelectorAll('.schedule-row').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(4px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Smooth transitions for special rows
    document.querySelectorAll('.special-row').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.01)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>
@endpush