<!-- resources/views/settings/partials/security-config.blade.php -->
<div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-5">
    <div>
        <h3 class="text-base font-bold text-slate-900">Security & Institutional Governance</h3>
        <p class="text-xs text-slate-500 mt-0.5">Control administrative multi-factor protocols and student ledger locks.</p>
    </div>

    <div class="space-y-4 pt-2">
        <!-- 2FA Toggle -->
        <div class="flex items-center justify-between p-3.5 rounded-xl bg-slate-50 border border-slate-100">
            <div>
                <h4 class="text-xs font-bold text-slate-900">Enforce Two-Factor Authentication (2FA)</h4>
                <p class="text-[11px] text-slate-500 mt-0.5">Requires all faculty deans and registrars to provide an authenticator OTP code on sign-in.</p>
            </div>
            <input type="checkbox" x-model="notifications.twoFactor" class="w-4 h-4 rounded text-brand-600 border-slate-300 focus:ring-brand-500">
        </div>

        <!-- Grade Audit Alert Toggle -->
        <div class="flex items-center justify-between p-3.5 rounded-xl bg-slate-50 border border-slate-100">
            <div>
                <h4 class="text-xs font-bold text-slate-900">Automated Grade Audit Alerts</h4>
                <p class="text-[11px] text-slate-500 mt-0.5">Notify the Chief Dean when a professor modifies letter marks post-examination.</p>
            </div>
            <input type="checkbox" x-model="notifications.auditLogs" class="w-4 h-4 rounded text-brand-600 border-slate-300 focus:ring-brand-500">
        </div>

        <!-- Real-time Email Notifications Toggle -->
        <div class="flex items-center justify-between p-3.5 rounded-xl bg-slate-50 border border-slate-100">
            <div>
                <h4 class="text-xs font-bold text-slate-900">Real-time Email Notifications</h4>
                <p class="text-[11px] text-slate-500 mt-0.5">Receive student enrollment and absence alerts on sarah.vance@edupulse.edu.</p>
            </div>
            <input type="checkbox" x-model="notifications.emailAlerts" class="w-4 h-4 rounded text-brand-600 border-slate-300 focus:ring-brand-500">
        </div>
    </div>

    <div class="pt-4 border-t border-slate-100 flex justify-end">
        <button type="button" 
                @click="saveSettings()" 
                class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-md shadow-brand-600/30 transition-all">
            Save System Configurations
        </button>
    </div>
</div>
