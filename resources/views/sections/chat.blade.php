<x-layout :title="'Messages | Azenion'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />
        <div class="relative mx-auto max-w-[1200px] px-5 pb-24 sm:px-8">
            <x-reveal class="rounded-[2rem] card-surface-soft p-6 sm:p-10 shadow-card backdrop-blur-xl">
                <h1 class="text-3xl font-semibold text-ink-50 mb-6">Messages</h1>
                
                <div class="grid gap-6 md:grid-cols-3">
                    <!-- Sidebar -->
                    <div class="md:col-span-1 rounded-xl bg-ink-900/40 p-4 border border-ink-800 flex flex-col h-[600px]">
                        <!-- User Search Form -->
                        <form method="GET" action="{{ isset($conversation) ? route('chat.show', $conversation->id) : route('chat') }}" class="mb-4">
                            <div class="relative">
                                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search users to message..." class="w-full rounded-xl bg-ink-900/50 border border-ink-800 px-3 py-2.5 text-xs text-ink-50 focus:border-accent focus:outline-none pr-16">
                                <button type="submit" class="absolute right-1 top-1 bottom-1 px-3 rounded-lg bg-accent text-xs font-semibold text-white hover:bg-accent-400">Search</button>
                            </div>
                        </form>

                        <div class="flex-1 overflow-y-auto space-y-4 pr-1">
                            @if(isset($search) && $search !== '')
                                <div x-data="{
                                    startConversation(recipientId) {
                                        fetch('{{ route('chat.start') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify({ recipient_id: recipientId })
                                        })
                                        .then(res => res.json())
                                        .then(data => {
                                            if (data.redirect) {
                                                window.location.href = data.redirect;
                                            } else if (data.conversation_id) {
                                                window.location.href = '{{ route('chat.show', ':id') }}'.replace(':id', data.conversation_id);
                                            } else {
                                                window.location.reload();
                                            }
                                        })
                                        .catch(err => {
                                            console.error('Start conversation failed:', err);
                                            window.location.reload();
                                        });
                                    }
                                }">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-semibold text-accent-300 uppercase tracking-wider">Search Results</span>
                                        <a href="{{ isset($conversation) ? route('chat.show', $conversation->id) : route('chat') }}" class="text-xs text-ink-400 hover:text-ink-50">Clear</a>
                                    </div>
                                    <div class="space-y-2">
                                        @forelse($users ?? [] as $searchedUser)
                                            <button type="button" @click="startConversation({{ $searchedUser->id }})" class="w-full text-left rounded-xl p-2.5 bg-ink-900/80 hover:bg-accent/10 transition-all border border-ink-800 hover:border-accent/20 flex items-center justify-between">
                                                <div class="truncate">
                                                    <div class="text-xs font-semibold text-ink-50 truncate">{{ $searchedUser->profile->full_name ?? $searchedUser->name }}</div>
                                                    <div class="text-[10px] text-ink-400 truncate">{{ $searchedUser->email }}</div>
                                                </div>
                                                <span class="text-[10px] text-accent-300 font-medium shrink-0 ml-2">Chat &rarr;</span>
                                            </button>
                                        @empty
                                            <div class="text-xs text-ink-400 py-3 text-center">No users found.</div>
                                        @endforelse
                                    </div>
                                </div>
                            @endif

                            <div>
                                <h2 class="text-xs font-semibold text-ink-300 uppercase tracking-wider mb-3">Conversations</h2>
                                <div class="space-y-2">
                                    @forelse($conversations ?? [] as $conv)
                                        @php
                                            $otherUser = $conv->users->where('id', '!=', auth()->id())->first();
                                            $lastMsg = $conv->messages->first();
                                            $isActive = isset($conversation) && $conversation->id === $conv->id;
                                        @endphp
                                        <a href="{{ route('chat.show', $conv->id) }}" class="block rounded-xl p-3 transition-all border {{ $isActive ? 'bg-accent/15 border-accent/40 shadow-glow-sm' : 'hover:bg-accent/10 border-transparent hover:border-accent/20 bg-ink-900/30' }}">
                                            <div class="text-sm font-semibold text-ink-50">{{ $otherUser->profile->full_name ?? $otherUser->name ?? 'User' }}</div>
                                            <div class="text-xs text-ink-400 truncate mt-1">{{ $lastMsg->content ?? 'Started conversation' }}</div>
                                        </a>
                                    @empty
                                        <div class="text-xs text-ink-400 py-6 text-center">No active conversations. Search above to start one!</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Area -->
                    @isset($conversation)
                        @php
                            $otherUser = $conversation->users->where('id', '!=', auth()->id())->first();
                            $otherUserId = $otherUser->id;
                        @endphp
                        <script>
                        window.chatApp = function({ conversationId, currentUserId, otherUserId, initialMessages, storeMessageRoute, storeVoiceRoute, initiateCallRoute, answerCallRoute, declineCallRoute, endCallRoute, iceRoute, negotiateRoute }) {
                            return {
                                messages: initialMessages,
                                newMessage: '',
                                isRecording: false,
                                mediaRecorder: null,
                                audioChunks: [],
                                recordingStartTime: null,
                                recordingTimer: null,
                                callState: { active: false, isIncoming: false, type: 'voice', connected: false, callId: null, callerId: null },
                                peerConnection: null, localStream: null, remoteStream: null, isMuted: false, isVideoOff: false, isScreenSharing: false, screenShareTrack: null,
                                otherUserName: @js($otherUser->profile->full_name ?? $otherUser->name),
                                 async init() {
                                     // Poll every 2.5 seconds for new messages and incoming calls
                                     setInterval(async () => {
                                         try {
                                             const lastMsg = this.messages[this.messages.length - 1];
                                             const lastId = lastMsg ? lastMsg.id : 0;
                                             const activeCallId = this.callState.callId || '';
                                             const res = await fetch(`{{ route('chat.poll', $conversation->id) }}?last_message_id=${lastId}&active_call_id=${activeCallId}`, { headers: { 'Accept': 'application/json' } });
                                             const data = await res.json();
                                             
                                             if (data.messages && data.messages.length > 0) {
                                                 data.messages.forEach(m => {
                                                     if (!this.messages.some(existing => existing.id === m.id)) {
                                                         this.messages.push(m);
                                                         this.scrollToBottom();
                                                     }
                                                 });
                                             }

                                             if (data.ringing_call && !this.callState.active) {
                                                 this.handleIncomingCall({
                                                     call_id: data.ringing_call.call_id,
                                                     caller_id: data.ringing_call.caller_id,
                                                     type: data.ringing_call.type,
                                                     offer: data.ringing_call.offer
                                                 });
                                             }

                                             if (data.call_status && this.callState.active) {
                                                 if (data.call_status.status === 'answered' && !this.callState.connected && data.call_status.answer) {
                                                     this.handleCallAnswered({ answer: data.call_status.answer });
                                                 } else if (['declined', 'ended'].includes(data.call_status.status)) {
                                                     this.endCallLocal();
                                                 }
                                             }
                                         } catch (err) {
                                             // silent poll error
                                         }
                                     }, 2500);

                                     if (window.Echo) {
                                         window.Echo.private('conversation.' + conversationId)
                                             .listen('MessageSent', (e) => {
                                                 if (e.sender_id !== currentUserId) {
                                                     this.messages.push({ id: e.id, content: e.content, type: e.type || 'text', audio_url: e.audio_url, duration: e.duration, call_data: e.call_data, sender_name: e.sender_name, sender_id: e.sender_id, is_me: false });
                                                     this.scrollToBottom();
                                                 }
                                             })
                                             .listen('CallInitiated', (e) => { if (e.receiver_id === currentUserId) this.handleIncomingCall(e); })
                                             .listen('CallAnswered', (e) => this.handleCallAnswered(e))
                                             .listen('CallDeclined', (e) => this.handleCallDeclined(e))
                                             .listen('CallEnded', (e) => this.handleCallEnded(e))
                                             .listen('CallICECandidate', (e) => { if (e.from_user_id !== currentUserId) this.handleICECandidate(e); })
                                             .listen('CallNegotiation', (e) => { if (e.from_user_id !== currentUserId) this.handleNegotiation(e); });
                                     }
                                 },
                                sendMessage() {
                                    if (!this.newMessage.trim()) return;
                                    fetch(storeMessageRoute, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }, body: JSON.stringify({ content: this.newMessage }) })
                                    .then(res => res.json()).then(data => { if (data.success) { this.messages.push(data.message); this.newMessage = ''; this.scrollToBottom(); } });
                                },
                                async startRecording() {
                                    if (this.isRecording) { this.stopRecording(); return; }
                                    try {
                                        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                                        let mimeType = 'audio/webm';
                                        if (!MediaRecorder.isTypeSupported(mimeType)) {
                                            if (MediaRecorder.isTypeSupported('audio/webm;codecs=opus')) mimeType = 'audio/webm;codecs=opus';
                                            else if (MediaRecorder.isTypeSupported('audio/mp4')) mimeType = 'audio/mp4';
                                            else mimeType = '';
                                        }
                                        this.mediaRecorder = mimeType ? new MediaRecorder(stream, { mimeType }) : new MediaRecorder(stream);
                                        this.audioChunks = []; this.recordingStartTime = Date.now();
                                        this.mediaRecorder.ondataavailable = (e) => { if (e.data.size > 0) this.audioChunks.push(e.data); };
                                        this.mediaRecorder.onstop = () => { this.uploadVoiceMessage(); stream.getTracks().forEach(t => t.stop()); };
                                        this.mediaRecorder.start(100); this.isRecording = true; this.startRecordingTimer();
                                    } catch (err) { console.error('Recording failed:', err); alert('Could not access microphone: ' + (err.message || err)); }
                                },
                                stopRecording() { if (this.mediaRecorder && this.isRecording) { this.mediaRecorder.stop(); this.isRecording = false; clearInterval(this.recordingTimer); this.recordingTimer = null; } },
                                startRecordingTimer() { this.recordingTimer = setInterval(() => { if (Date.now() - this.recordingStartTime > 300000) this.stopRecording(); }, 1000); },
                                async uploadVoiceMessage() {
                                    const type = this.mediaRecorder?.mimeType || 'audio/webm';
                                    const ext = type.includes('mp4') ? 'mp4' : 'webm';
                                    const blob = new Blob(this.audioChunks, { type });
                                    const duration = Math.round((Date.now() - this.recordingStartTime) / 1000);
                                    if (duration < 1) { alert('Recording too short'); return; }
                                    const formData = new FormData(); formData.append('audio', blob, 'voice-' + Date.now() + '.' + ext); formData.append('duration', duration);
                                    try {
                                        const response = await fetch(storeVoiceRoute, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }, body: formData });
                                        const data = await response.json(); if (data.success) { this.messages.push(data.message); this.scrollToBottom(); } else { alert(data.message || 'Voice upload failed'); }
                                    } catch (err) { console.error('Upload failed:', err); alert('Voice upload failed'); }
                                },
                                scrollToBottom() { this.$nextTick(() => { const c = this.$refs.messagesContainer; if(c) c.scrollTop = c.scrollHeight; }); },
                                formatTime(s) { const m = Math.floor(s/60); const sec = s%60; return m + ':' + String(sec).padStart(2,'0'); },
                                getCallStatusText(d) { const m = { answered:'Call ended', declined:'Call declined', missed:'Missed call', ended:'Call ended' }; return m[d.status] || 'Call'; },
                                togglePlay(msg) {
                                    if (!msg.audioElement) {
                                        msg.audioElement = new Audio(msg.audio_url);
                                        msg.audioElement.addEventListener('timeupdate', () => { msg.playTime = msg.audioElement.currentTime; msg.playProgress = (msg.playTime / msg.duration) * 100; });
                                        msg.audioElement.addEventListener('ended', () => { msg.isPlaying=false; msg.playTime=0; msg.playProgress=0; });
                                        msg.audioElement.addEventListener('error', () => alert('Cannot play audio'));
                                    }
                                    if (msg.isPlaying) { msg.audioElement.pause(); msg.isPlaying=false; } else { this.messages.forEach(m=>{ if(m.audioElement && m.isPlaying && m!==msg){ m.audioElement.pause(); m.isPlaying=false; }}); msg.audioElement.play().catch(()=>alert('Playback failed')); msg.isPlaying=true; }
                                },
                                async startCall(type) {
                                    this.callState = { active:true, isIncoming:false, type, connected:false, callId:null, callerId:currentUserId };
                                    try {
                                        this.localStream = await navigator.mediaDevices.getUserMedia({ audio:true, video: type==='video' });
                                        this.setupPeerConnection(); const offer = await this.peerConnection.createOffer(); await this.peerConnection.setLocalDescription(offer);
                                        const res = await fetch(initiateCallRoute, { method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}, body: JSON.stringify({ type, offer: offer.toJSON ? offer.toJSON() : offer, receiver_id: otherUserId }) });
                                        const data = await res.json(); if(data.success) this.callState.callId = data.call_id; else throw new Error(data.error||'Call failed');
                                    } catch(err){ console.error('Call failed:',err); this.endCallLocal(); alert('Could not start call: '+(err.message||err)); }
                                },
                                handleIncomingCall(e){ this.callState={ active:true, isIncoming:true, type:e.type, connected:false, callId:e.call_id, callerId:e.caller_id }; this.setupPeerConnection(); this.peerConnection.setRemoteDescription(new RTCSessionDescription(e.offer)); },
                                async answerCall(){
                                    try{
                                        this.localStream = await navigator.mediaDevices.getUserMedia({ audio:true, video: this.callState.type==='video' });
                                        const answer = await this.peerConnection.createAnswer(); await this.peerConnection.setLocalDescription(answer);
                                        await fetch(answerCallRoute.replace(':callId', this.callState.callId), { method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}, body: JSON.stringify({ answer: answer.toJSON ? answer.toJSON() : answer }) });
                                        this.callState.isIncoming=false; this.callState.connected=true;
                                    }catch(err){ console.error('Answer failed:',err); this.declineCall(); }
                                },
                                async declineCall(){ try{ await fetch(declineCallRoute.replace(':callId', this.callState.callId), { method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}, body: JSON.stringify({}) }); }catch(e){} this.endCallLocal(); },
                                handleCallAnswered(e){ this.peerConnection.setRemoteDescription(new RTCSessionDescription(e.answer)); this.callState.isIncoming=false; this.callState.connected=true; },
                                handleCallDeclined(e){ this.endCallLocal(); alert('Call declined'); },
                                handleCallEnded(e){ this.endCallLocal(); },
                                async endCall(){ if(!this.callState.callId){ this.endCallLocal(); return;} try{ await fetch(endCallRoute.replace(':callId', this.callState.callId), { method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}, body: JSON.stringify({}) }); }catch(e){} this.endCallLocal(); },
                                endCallLocal(){ if(this.peerConnection){ this.peerConnection.close(); this.peerConnection=null; } if(this.localStream){ this.localStream.getTracks().forEach(t=>t.stop()); this.localStream=null; } if(this.screenShareTrack){ this.screenShareTrack.stop(); this.screenShareTrack=null; } this.callState={ active:false, isIncoming:false, type:'voice', connected:false, callId:null, callerId:null }; this.isMuted=false; this.isVideoOff=false; this.isScreenSharing=false; },
                                setupPeerConnection(){
                                    this.peerConnection = new RTCPeerConnection({ iceServers:[{urls:'stun:stun.l.google.com:19302'},{urls:'stun:stun1.l.google.com:19302'}] });
                                    this.peerConnection.onicecandidate=(e)=>{ if(e.candidate) this.sendICECandidate(e.candidate.toJSON()); };
                                    this.peerConnection.ontrack=(e)=>{ this.remoteStream=e.streams[0]; this.$nextTick(()=>{ const v=this.$refs.remoteVideo; if(v) v.srcObject=this.remoteStream; }); };
                                    this.peerConnection.onconnectionstatechange=()=>{ if(this.peerConnection.connectionState==='connected') this.callState.connected=true; else if(['failed','disconnected'].includes(this.peerConnection.connectionState)) this.endCallLocal(); };
                                    this.localStream.getTracks().forEach(t=> this.peerConnection.addTrack(t, this.localStream));
                                    this.$nextTick(()=>{ const v=this.$refs.localVideo; if(v) v.srcObject=this.localStream; });
                                },
                                sendICECandidate(c){ if(!this.callState.callId) return; fetch(iceRoute.replace(':callId', this.callState.callId), { method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}, body: JSON.stringify({ candidate:c }) }); },
                                handleICECandidate(e){ if(this.peerConnection) this.peerConnection.addIceCandidate(new RTCIceCandidate(e.candidate)); },
                                handleNegotiation(e){ if(this.peerConnection) this.peerConnection.setRemoteDescription(new RTCSessionDescription(e.offer)).then(()=>this.peerConnection.createAnswer()).then(a=>this.peerConnection.setLocalDescription(a)).then(()=>this.sendNegotiation(this.peerConnection.localDescription.toJSON())); },
                                sendNegotiation(o){ if(!this.callState.callId) return; fetch(negotiateRoute.replace(':callId', this.callState.callId), { method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}, body: JSON.stringify({ offer:o }) }); },
                                toggleMute(){ this.isMuted=!this.isMuted; if(this.localStream) this.localStream.getAudioTracks().forEach(t=> t.enabled=!this.isMuted); },
                                toggleVideo(){ this.isVideoOff=!this.isVideoOff; if(this.localStream) this.localStream.getVideoTracks().forEach(t=> t.enabled=!this.isVideoOff); },
                                async toggleScreenShare(){
                                    if(this.isScreenSharing){ if(this.screenShareTrack){ this.screenShareTrack.stop(); this.screenShareTrack=null; } if(this.localStream){ const vt=this.localStream.getVideoTracks()[0]; const sender=this.peerConnection.getSenders().find(s=>s.track.kind==='video'); if(sender&&vt) await sender.replaceTrack(vt); } this.isScreenSharing=false;
                                    } else { try{ const s=await navigator.mediaDevices.getDisplayMedia({video:true,audio:true}); this.screenShareTrack=s.getVideoTracks()[0]; const sender=this.peerConnection.getSenders().find(s=>s.track.kind==='video'); if(sender) await sender.replaceTrack(this.screenShareTrack); this.screenShareTrack.onended=()=>this.toggleScreenShare(); this.isScreenSharing=true; }catch(err){ console.error('Screen share failed:',err); } }
                                },
                            };
                        };
                        </script>
                        <div x-data="window.chatApp({
                            conversationId: '{{ $conversation->id }}',
                            currentUserId: {{ auth()->id() }},
                            otherUserId: {{ $otherUserId }},
                            storeMessageRoute: '{{ route('chat.messages.store', $conversation->id) }}',
                            storeVoiceRoute: '{{ route('chat.messages.voice', $conversation->id) }}',
                            initiateCallRoute: '{{ route('chat.call.initiate', $conversation->id) }}',
                            answerCallRoute: '{{ route('chat.call.answer', ':callId') }}',
                            declineCallRoute: '{{ route('chat.call.decline', ':callId') }}',
                            endCallRoute: '{{ route('chat.call.end', ':callId') }}',
                            iceRoute: '{{ route('chat.call.ice', ':callId') }}',
                            negotiateRoute: '{{ route('chat.call.negotiate', ':callId') }}',
                            initialMessages: @js($conversation->messages->map(fn($m) => [
                                'id' => $m->id,
                                'content' => $m->content,
                                'type' => $m->type ?? 'text',
                                'audio_url' => $m->audio_url ?? null,
                                'duration' => $m->duration ?? null,
                                'call_data' => $m->call_data ?? null,
                                'sender_name' => $m->sender->profile->full_name ?? $m->sender->name,
                                'sender_id' => $m->sender_id,
                                'is_me' => $m->sender_id === auth()->id(),
                            ])),
                        })" class="md:col-span-2 rounded-xl bg-ink-900/40 p-6 border border-ink-800 flex flex-col h-[600px]">
                            <div class="flex items-center justify-between border-b border-ink-800 pb-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-accent/20 flex items-center justify-center text-accent-300 font-bold">
                                        {{ substr($otherUser->profile->full_name ?? $otherUser->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h2 class="text-base font-semibold text-ink-50">{{ $otherUser->profile->full_name ?? $otherUser->name ?? 'Chat' }}</h2>
                                        <p class="text-xs text-ink-400">{{ $otherUser->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="startCall('voice')" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full bg-green-500/15 border border-green-500/30 text-green-400 hover:bg-green-500/25 transition-all text-xs font-semibold" title="Start Voice Call">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        <span>Call</span>
                                    </button>
                                    <button type="button" @click="startCall('video')" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full bg-blue-500/15 border border-blue-500/30 text-blue-400 hover:bg-blue-500/25 transition-all text-xs font-semibold" title="Start Video Call">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        <span>Video</span>
                                    </button>
                                </div>
                            </div>

                            <div x-ref="messagesContainer" class="mt-4 flex-1 space-y-4 overflow-y-auto p-4 rounded-xl bg-ink-900/50 border border-ink-800">
                                <template x-for="msg in messages" :key="msg.id">
                                    <div class="flex flex-col" :class="msg.is_me ? 'items-end' : 'items-start'">
                                        <div class="text-[11px] text-ink-400 mb-1" x-text="msg.is_me ? 'You' : msg.sender_name"></div>
                                        <template x-if="msg.type === 'voice'">
                                            <div class="flex items-center gap-3 rounded-xl bg-ink-800/50 p-3 max-w-md" :class="msg.is_me ? 'bg-accent/20' : ''">
                                                <button @click="togglePlay(msg)" class="p-2 rounded-full bg-ink-900 text-ink-100 hover:bg-ink-700 transition-colors flex-shrink-0" :aria-label="msg.isPlaying ? 'Pause' : 'Play'">
                                                    <svg x-show="!msg.isPlaying" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                                    <svg x-show="msg.isPlaying" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                                                </button>
                                                <div class="flex-1 min-w-0">
                                                    <div class="h-2 bg-ink-700 rounded-full overflow-hidden" style="width: 100%;">
                                                        <div class="h-full bg-accent rounded-full transition-all" :style="'width: ' + (msg.playProgress || 0) + '%'"></div>
                                                    </div>
                                                    <div class="flex justify-between text-[10px] text-ink-500 mt-1">
                                                        <span x-text="formatTime(msg.playTime || 0)"></span>
                                                        <span x-text="formatTime(msg.duration || 0)"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="msg.type === 'call_log'">
                                            <div class="rounded-xl bg-ink-800/50 p-3 max-w-md text-center" :class="msg.is_me ? 'bg-accent/10' : ''">
                                                <div class="flex items-center justify-center gap-2 text-sm text-ink-400">
                                                    <span x-text="msg.call_data.type === 'video' ? '📹' : '📞'"></span>
                                                    <span x-text="getCallStatusText(msg.call_data)"></span>
                                                    <template x-if="msg.call_data.duration > 0">
                                                        <span class="text-ink-500">·</span>
                                                        <span x-text="formatTime(msg.call_data.duration)"></span>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="msg.type === 'text' || !msg.type">
                                            <div class="rounded-2xl px-4 py-3 max-w-md text-sm" :class="msg.is_me ? 'bg-accent text-white' : 'bg-ink-800 text-ink-100'" x-text="msg.content"></div>
                                        </template>
                                    </div>
                                </template>
                            </div>

                            <div class="mt-4 flex gap-3">
                                <button @click="startRecording" class="p-3 rounded-xl bg-red-500/20 text-red-400 hover:bg-red-500/30 transition-colors" title="Voice Message" :class="{ 'ring-2 ring-red-400': isRecording }">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm5.3-3c0 3-2.54 5.1-5.3 5.1S6.7 14 6.7 11H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c3.28-.48 6-3.3 6-6.72h-1.7z"/></svg>
                                </button>
                                <form @submit.prevent="sendMessage()" class="flex-1 flex gap-2">
                                    <input type="text" x-model="newMessage" required autocomplete="off" placeholder="Type a message..." class="flex-1 rounded-xl bg-ink-900/50 border-2 border-ink-700 px-4 py-3 text-sm text-ink-50 placeholder-ink-600 transition-all focus:border-accent-400 focus:shadow-[0_0_0_2px_rgba(109,109,255,0.25)] focus:outline-none">
                                    <button type="submit" class="rounded-xl bg-accent px-6 py-3 text-sm font-semibold text-white hover:bg-accent-400">Send</button>
                                </form>
                            </div>
                        </div>

                        <!-- Call Modal -->
                        <div x-cloak x-show="callState.active" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4" style="display: none;">
                            <div class="w-full max-w-lg rounded-2xl bg-[#050507] p-8 border border-ink-700 shadow-2xl">
                                <div class="text-center mb-6">
                                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-accent/20 flex items-center justify-center" x-data="{ pulse: true }" x-init="setInterval(() => pulse = !pulse, 1000)">
                                        <div class="w-12 h-12 rounded-full bg-accent" :class="{ 'animate-pulse': pulse }"></div>
                                    </div>
                                    <h3 class="text-xl font-semibold text-ink-50" x-text="callState.isIncoming ? 'Incoming ' + (callState.type === 'video' ? 'Video' : 'Voice') + ' Call' : 'Calling...'"></h3>
                                    <p class="text-ink-400 mt-1" x-text="callState.isIncoming ? otherUserName + ' is calling' : 'Ringing...'"></p>
                                </div>

                                <template x-if="callState.isIncoming">
                                    <div class="flex gap-4 justify-center">
                                        <button @click="declineCall()" class="flex-1 py-3 rounded-xl bg-red-500/20 text-red-400 font-semibold hover:bg-red-500/30">Decline</button>
                                        <button @click="answerCall()" class="flex-1 py-3 rounded-xl bg-green-500 text-white font-semibold hover:bg-green-600">Answer</button>
                                    </div>
                                </template>

                                <template x-if="!callState.isIncoming && callState.connected">
                                    <div class="relative aspect-video w-full max-w-md mx-auto rounded-xl overflow-hidden bg-black border border-ink-700">
                                        <video x-ref="remoteVideo" autoplay playsinline class="w-full h-full"></video>
                                        <video x-ref="localVideo" autoplay playsinline muted class="absolute bottom-4 right-4 w-32 h-24 rounded-lg border border-ink-600 object-cover"></video>
                                    </div>
                                    <div class="mt-6 flex justify-center gap-4">
                                        <button @click="toggleMute()" class="p-3 rounded-full bg-ink-800 text-ink-100 hover:bg-ink-700 transition-colors" :class="{ 'bg-red-500/20 text-red-400': isMuted }" title="Mute">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!isMuted"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6m0 0l3 3m0 0l-3 3m3-3H8"/></svg>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="isMuted"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/></svg>
                                        </button>
                                        <button @click="toggleVideo()" x-show="callState.type === 'video'" class="p-3 rounded-full bg-ink-800 text-ink-100 hover:bg-ink-700 transition-colors" :class="{ 'bg-red-500/20 text-red-400': isVideoOff }" title="Toggle Video">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!isVideoOff"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="isVideoOff"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4l16 16"/></svg>
                                        </button>
                                        <button @click="toggleScreenShare()" x-show="callState.type === 'video'" class="p-3 rounded-full bg-ink-800 text-ink-100 hover:bg-ink-700 transition-colors" :class="{ 'bg-green-500/20 text-green-400': isScreenSharing }" title="Share Screen">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                        </button>
                                        <button @click="endCall()" class="p-3 rounded-full bg-red-500 text-white font-semibold hover:bg-red-600 transition-colors" title="End Call">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    @else
                        <div class="md:col-span-2 rounded-xl bg-ink-900/40 p-6 border border-ink-800 flex items-center justify-center text-ink-400 text-center h-[600px]">
                            <div>
                                <p class="text-base font-medium text-ink-200">No conversation selected</p>
                                <p class="text-xs text-ink-400 mt-1">Select a conversation from the sidebar or search for a user to start chatting.</p>
                            </div>
                        </div>
                    @endisset
                </div>
            </x-reveal>
        </div>
    </main>
</x-layout>

