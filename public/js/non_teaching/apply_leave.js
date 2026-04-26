(() => {
    'use strict';

    /* ── DOM refs ── */
    const form          = document.getElementById('leaveForm');
    const startDateEl   = document.getElementById('startDate');
    const endDateEl     = document.getElementById('endDate');
    const totalDaysEl   = document.getElementById('totalDays');
    const leaveTypeEl   = document.getElementById('leaveType');
    const submitBtn     = document.getElementById('submitBtn');
    const submitSpinner = document.getElementById('submitSpinner');
    const submitIcon    = document.getElementById('submitIcon');
    const submitText    = document.getElementById('submitText');
    const toastCont     = document.getElementById('toastContainer');
    const vacBal        = document.getElementById('vacBal');
    const sickBal       = document.getElementById('sickBal');

    /* ── Day calculation (inclusive, weekdays only) ── */
    function calcDays(start, end) {
        if (!start || !end) return 0;

        let s = new Date(start);
        let e = new Date(end);

        if (e < s) return 0;

        let days = 0;

        while (s <= e) {
            const dow = s.getDay();
            if (dow !== 0 && dow !== 6) days++;
            s.setDate(s.getDate() + 1);
        }

        return days;
    }

    function updateDays() {
        const days = calcDays(startDateEl.value, endDateEl.value);
        totalDaysEl.value = days > 0 ? days : '';
    }

    startDateEl.addEventListener('change', () => {
        if (endDateEl.value && endDateEl.value < startDateEl.value) {
            endDateEl.value = startDateEl.value;
        }

        endDateEl.min = startDateEl.value;
        updateDays();
    });

    endDateEl.addEventListener('change', updateDays);

    /* ── Toast helper ── */
    function toast(msg, type = 'success') {
        const t = document.createElement('div');
        t.className = `toast-msg ${type}`;
        t.innerHTML = `
            <i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'exclamation-circle-fill'}"></i>
            ${msg}
        `;
        toastCont.appendChild(t);
        setTimeout(() => t.remove(), 4000);
    }

    /* ── Loading state ── */
    function setLoading(loading) {
        submitBtn.disabled = loading;
        submitSpinner.style.display = loading ? 'block' : 'none';
        submitIcon.style.display    = loading ? 'none'  : 'inline';
        submitText.textContent      = loading ? 'Submitting…' : 'Submit Digital Leave Form';
    }

    /* ── Form submit → AJAX ── */
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Client-side validation
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            toast('Please fill in all required fields.', 'error');
            return;
        }

        const days = parseInt(totalDaysEl.value);

        if (!days || days <= 0) {
            toast('Please select a valid date range.', 'error');
            return;
        }

        setLoading(true);

        const body = new FormData(form);

        try {
            const res  = await fetch('../../../app/api/non_teaching/apply_leave.php?action=store', {
                method: 'POST',
                body,
            });

            const json = await res.json();

            if (json.success) {
                toast(json.message, 'success');

                form.reset();
                form.classList.remove('was-validated');
                totalDaysEl.value = '';

                // Update displayed balance
                if (json.data.vacation_leave !== undefined) {
                    vacBal.textContent  = json.data.vacation_leave;
                    sickBal.textContent = json.data.sick_leave;
                }
            } else {
                toast(json.message, 'error');
            }
        } catch (err) {
            console.error(err);
            toast('Network error. Please try again.', 'error');
        } finally {
            setLoading(false);
        }
    });

    /* ── Print history ── */
    document.getElementById('printHistoryBtn').addEventListener('click', async () => {
        try {
            const res  = await fetch('../../../app/api/non_teaching/apply_leave.php?action=history');
            const json = await res.json();

            if (!json.success || !json.data.records.length) {
                toast('No leave records found.', 'error');
                return;
            }

            // Build printable table
            const rows = json.data.records.map(r => `
                <tr>
                    <td>${r.id}</td>
                    <td>${r.leave_type}</td>
                    <td>${r.start_date}</td>
                    <td>${r.end_date}</td>
                    <td>${r.days}</td>
                    <td>${r.status}</td>
                    <td>${r.created_at}</td>
                </tr>
            `).join('');

            const win = window.open('', '_blank');

            win.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Leave History</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            font-size: 13px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 1rem;
                        }
                        th, td {
                            border: 1px solid #ccc;
                            padding: 6px 10px;
                            text-align: left;
                        }
                        th {
                            background: #2e7d4f;
                            color: #fff;
                        }
                        h2 {
                            color: #2e7d4f;
                            margin-bottom: .25rem;
                        }
                        p {
                            color: #555;
                            margin-top: 0;
                        }
                    </style>
                </head>
                <body>
                    <h2>Leave History</h2>
                    <p>Printed: ${new Date().toLocaleString()}</p>

                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Days</th>
                                <th>Status</th>
                                <th>Filed At</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </body>
                </html>
            `);

            win.document.close();
            win.print();
        } catch (err) {
            console.error(err);
            toast('Failed to fetch history.', 'error');
        }
    });

})();