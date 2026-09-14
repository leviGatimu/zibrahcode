<!-- Shared play/watch modal — opened via openEpisodePlayer(button) reading data-* attrs -->
<div id="episode-player-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-6">
    <div class="absolute inset-0 bg-brand-black/80 backdrop-blur-sm" onclick="closeEpisodePlayer()"></div>
    <div class="relative z-10 w-full max-w-lg bg-white shadow-2xl">
        <div class="flex items-center justify-between px-6 py-5 border-b border-brand-gray-100">
            <p id="episode-player-title" class="font-bold text-brand-black text-sm uppercase tracking-widest truncate pr-4"></p>
            <button type="button" onclick="closeEpisodePlayer()" class="text-brand-gray-400 hover:text-brand-gold transition-colors flex-shrink-0">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l18 12" />
                </svg>
            </button>
        </div>

        <!-- AUDIO MODE -->
        <div id="episode-player-audio-wrap" class="p-8">
            <img id="episode-player-cover" src="" alt="" class="w-full h-auto mb-8 shadow-xl">
            <audio id="episode-player-audio" class="hidden"></audio>
            <div class="flex items-center justify-center gap-8 mb-6">
                <button type="button" onclick="skipAudio(-15)" class="text-brand-gray-500 hover:text-brand-gold transition-colors" aria-label="Back 15 seconds">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                </button>
                <button type="button" id="episode-player-toggle" onclick="toggleAudioPlay(this)" data-playing="0"
                    class="w-16 h-16 rounded-full bg-brand-black text-white flex items-center justify-center hover:bg-brand-gold transition-colors flex-shrink-0">
                    <svg class="icon-play w-6 h-6 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                    <svg class="icon-pause w-6 h-6 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 5h4v14H6zm8 0h4v14h-4z" /></svg>
                </button>
                <button type="button" onclick="skipAudio(15)" class="text-brand-gray-500 hover:text-brand-gold transition-colors" aria-label="Forward 15 seconds">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 15l6-6m0 0l-6-6m6 6H9a6 6 0 000 12h3" />
                    </svg>
                </button>
            </div>
            <div class="w-full h-1 bg-brand-gray-100 cursor-pointer" id="episode-player-seek-track" onclick="seekAudio(event)">
                <div id="episode-player-seek-fill" class="h-full bg-brand-gold" style="width:0%"></div>
            </div>
        </div>

        <!-- VIDEO MODE -->
        <div id="episode-player-video-wrap" class="hidden bg-black">
            <video id="episode-player-video" class="w-full" controls></video>
        </div>
    </div>
</div>

<script>
    function openEpisodePlayer(btn) {
        const mediaType = btn.dataset.mediaType;
        const src = btn.dataset.src;
        const title = btn.dataset.title;
        const cover = btn.dataset.cover;

        document.getElementById('episode-player-title').textContent = title;
        const audioWrap = document.getElementById('episode-player-audio-wrap');
        const videoWrap = document.getElementById('episode-player-video-wrap');
        const audioEl = document.getElementById('episode-player-audio');
        const videoEl = document.getElementById('episode-player-video');

        if (mediaType === 'video') {
            audioWrap.classList.add('hidden');
            videoWrap.classList.remove('hidden');
            videoEl.src = src;
            videoEl.play().catch(() => {});
        } else {
            videoWrap.classList.add('hidden');
            audioWrap.classList.remove('hidden');
            const coverEl = document.getElementById('episode-player-cover');
            coverEl.src = cover;
            coverEl.alt = title;
            audioEl.src = src;
            audioEl.play().catch(() => {});
            setPlayIcon(true);
        }
        document.getElementById('episode-player-modal').classList.remove('hidden');
    }

    function closeEpisodePlayer() {
        const audioEl = document.getElementById('episode-player-audio');
        const videoEl = document.getElementById('episode-player-video');
        audioEl.pause();
        videoEl.pause();
        document.getElementById('episode-player-modal').classList.add('hidden');
    }

    function setPlayIcon(playing) {
        const btn = document.getElementById('episode-player-toggle');
        btn.dataset.playing = playing ? '1' : '0';
        btn.querySelector('.icon-play').classList.toggle('hidden', playing);
        btn.querySelector('.icon-pause').classList.toggle('hidden', !playing);
    }

    function toggleAudioPlay(btn) {
        const audio = document.getElementById('episode-player-audio');
        if (audio.paused) {
            audio.play().catch(() => {});
            setPlayIcon(true);
        } else {
            audio.pause();
            setPlayIcon(false);
        }
    }

    function skipAudio(seconds) {
        const audio = document.getElementById('episode-player-audio');
        audio.currentTime = Math.max(0, audio.currentTime + seconds);
    }

    function seekAudio(evt) {
        const audio = document.getElementById('episode-player-audio');
        if (!audio.duration) return;
        const track = document.getElementById('episode-player-seek-track');
        const rect = track.getBoundingClientRect();
        const ratio = Math.min(1, Math.max(0, (evt.clientX - rect.left) / rect.width));
        audio.currentTime = ratio * audio.duration;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const audio = document.getElementById('episode-player-audio');
        audio.addEventListener('timeupdate', () => {
            if (!audio.duration) return;
            document.getElementById('episode-player-seek-fill').style.width = (audio.currentTime / audio.duration * 100) + '%';
        });
        audio.addEventListener('ended', () => setPlayIcon(false));
    });
</script>
