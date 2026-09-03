<div id="privacy-modal"
     class="hidden"
     style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;
            justify-content:center;background:rgba(10,25,49,.65);backdrop-filter:blur(3px);"
     onclick="if(event.target===this)closePrivacyModal()">

    <div style="background:#fff;border-radius:18px;width:min(700px,95vw);
                max-height:88vh;display:flex;flex-direction:column;
                box-shadow:0 24px 64px rgba(0,0,0,.25);overflow:hidden;">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#0a1931,#1c2a4d);
                    padding:20px 28px;display:flex;align-items:flex-start;
                    justify-content:space-between;flex-shrink:0;">
            <div>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:5px;">
                    <div style="width:34px;height:34px;border-radius:50%;
                                background:rgba(240,196,25,.15);border:1.5px solid rgba(240,196,25,.4);
                                display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-shield-halved" style="color:#f0c419;font-size:.85rem;"></i>
                    </div>
                    <h2 style="color:#f0c419;font-size:1rem;font-weight:800;margin:0;">Privacy Notice</h2>
                </div>
                <p style="color:rgba(255,255,255,.6);font-size:.72rem;margin:0;">
                    Project Jeremiah 33:3 — Guidance Services Office, NU Laguna<br>
                    Republic Act No. 10173 (Data Privacy Act of 2012)
                </p>
            </div>
            <button onclick="closePrivacyModal()"
                    style="background:rgba(255,255,255,.1);border:none;cursor:pointer;
                           width:30px;height:30px;border-radius:50%;color:#fff;font-size:1rem;
                           display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-left:12px;"
                    aria-label="Close">&times;</button>
        </div>

        {{-- Body --}}
        <div style="overflow-y:auto;padding:24px 28px;font-size:.85rem;color:#374151;line-height:1.75;">

            @foreach([
                ['1. Data Controller',
                 'The <strong>Guidance Services Office (GSO) of National University – Laguna</strong> is the personal information controller responsible for your personal data in this system.'],
                ['2. What We Collect',
                 '<ul style="margin:0 0 0 18px;padding:0;"><li><strong>Full name</strong> — to identify your submissions</li><li><strong>School email</strong> — for account verification and identity</li><li><strong>Program and year level</strong> — for academic segmentation</li><li><strong>e-Hayag posts</strong> — voluntary content that may include <strong>sensitive personal information</strong> under Sec. 3(l) of RA 10173</li></ul>'],
                ['3. Purpose of Processing',
                 'Your data is used solely to: operate the e-Hayag safe-space platform; allow counselors to monitor student well-being; run AI-assisted sentiment analysis to flag high-risk posts; generate anonymised analytics; and manage your account.'],
                ['4. Legal Basis',
                 'Processing is based on your <strong>freely given, specific, and informed consent</strong> under Sec. 13(a) of RA 10173. You may withdraw consent at any time by contacting the GSO.'],
                ['5. Data Retention — 5 Years',
                 'Your personal data will be retained for <strong>five (5) years</strong> from your last activity or account deactivation, whichever is later. After this period data is securely disposed of in accordance with NPC guidelines. Anonymised statistical data may be kept longer for institutional research.'],
                ['6. Your Rights',
                 'Under Sec. 16 of RA 10173 you have the right to: be informed, access your data, correct inaccuracies, request erasure, object to processing, data portability, withdraw consent, and claim damages for violations. Contact the GSO to exercise any of these rights.'],
                ['7. Security',
                 'We implement technical safeguards including hashed credentials, OTP email verification, access controls restricted to authorised GSO personnel, rate-limited endpoints, and secure data storage outside the web root.'],
                ['8. Contact',
                 'For privacy concerns or data subject requests, contact the <strong>Guidance Services Office</strong>, NU Laguna. You may also file a complaint with the <strong>National Privacy Commission</strong> at <a href="https://www.privacy.gov.ph" target="_blank" style="color:#0a1931;">www.privacy.gov.ph</a>.'],
            ] as [$heading, $body])
            <div style="margin-bottom:18px;">
                <h3 style="font-size:.75rem;font-weight:800;color:#0a1931;text-transform:uppercase;
                            letter-spacing:.5px;margin-bottom:7px;padding-bottom:5px;border-bottom:2px solid #f0c419;">
                    {{ $heading }}
                </h3>
                <div>{!! $body !!}</div>
            </div>
            @endforeach

        </div>

        {{-- Footer --}}
        <div style="padding:14px 28px;border-top:1px solid #f3f4f6;display:flex;
                    align-items:center;justify-content:space-between;flex-shrink:0;
                    background:#f9fafb;flex-wrap:wrap;gap:10px;">
            <span style="font-size:.7rem;color:#9ca3af;">Last updated: {{ date('F Y') }} — RA 10173 compliant</span>
            <button onclick="closePrivacyModal()"
                    style="padding:8px 22px;background:linear-gradient(135deg,#0a1931,#1c2a4d);
                           color:#f0c419;border:none;border-radius:8px;font-size:.85rem;
                           font-weight:700;cursor:pointer;">
                I Understand
            </button>
        </div>
    </div>
</div>

<script>
function openPrivacyModal(){
    const m = document.getElementById('privacy-modal');
    m.classList.remove('hidden');
    m.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closePrivacyModal(){
    const m = document.getElementById('privacy-modal');
    m.classList.add('hidden');
    m.style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e){ if(e.key==='Escape') closePrivacyModal(); });
</script>
