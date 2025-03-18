function validateForm() {
    let isValid = true;

    // Cek semua radio button terisi
    document.querySelectorAll(".katsinov-table").forEach((table) => {
        const filled = table.querySelectorAll(
            'input[type="radio"]:checked'
        ).length;
        const totalRows =
            table.querySelectorAll("tr:not(.total-row)").length - 1; // Exclude header

        if (filled < totalRows) {
            isValid = false;
            table.scrollIntoView({
                behavior: "smooth",
            });
            table.style.border = "2px solid red";
            setTimeout(() => (table.style.border = ""), 3000);
        }
    });

    return isValid;
}
function collectFormResponses() {
    const responses = [];
    
    document.querySelectorAll('[data-indicator]').forEach(indicatorContainer => {
        const indicatorNumber = parseInt(indicatorContainer.dataset.indicator);
        
        indicatorContainer.querySelectorAll('tr').forEach((row, index) => {
            const aspectCell = row.querySelector('.aspect-cell');
            if (!aspectCell) return; // Skip header and total rows
            
            const aspect = aspectCell.textContent.trim();
            const checkedRadio = row.querySelector('input[type="radio"]:checked');
            const score = checkedRadio ? parseInt(checkedRadio.value) : 0;
            
            responses.push({
                indicator: indicatorNumber,
                row: index, // Atau sesuaikan dengan nomor row yang benar
                aspect: aspect,
                score: score
            });
        });
    });
    
    return responses;
}


async function submitAllIndicators() {
    const btn = document.getElementById("submitAllBtn");

    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menyimpan...';

    try {
        const responses = collectFormResponses();
        const formData = new FormData(document.getElementById("katsinovForm"));

        responses.forEach((response, index) => {
            formData.append(`responses[${index}][indicator]`, response.indicator);
            formData.append(`responses[${index}][row]`, response.row);
            formData.append(`responses[${index}][aspect]`, response.aspect);
            formData.append(`responses[${index}][score]`, response.score);
        });
        

        const response = await fetch("/katsinov/store", {
            // ✏️ Perbaiki disini
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                Accept: "application/json",
            },
            body: formData,
        });

        const data = await response.json();
        if (!response.ok)
            throw new Error(data.message || "Gagal menyimpan data");

        Swal.fire({
            icon: "success",
            title: "🎉 Selamat!",
            html: `
            <div style="
                background: linear-gradient(135deg, #ffffff 0%, #f0f4f8 100%);
                border-radius: 20px; 
                padding: 30px; 
                text-align: center;
                max-width: 450px;
                margin: 0 auto;
                border: 1px solid rgba(23, 99, 105, 0.1);
                box-shadow: 0 20px 40px rgba(23, 99, 105, 0.1);
            ">
                <div style="
                    width: 80px;
                    height: 80px;
                    background-color: #e6f6f7;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0 auto 20px;
                    box-shadow: 0 10px 20px rgba(23, 99, 105, 0.1);
                ">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#176369" stroke-width="2.5">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                
                <h2 style="
                    color: #176369;
                    font-size: 22px;
                    font-weight: 700;
                    margin-bottom: 15px;
                ">
                    Indikator KATSINOV Berhasil
                </h2>
                
                <p style="
                    color: #2d3748; 
                    font-size: 16px; 
                    line-height: 1.6;
                    margin-bottom: 20px;
                ">
                    Terima kasih atas partisipasi Anda. Data Anda telah berhasil disimpan dalam sistem kami dengan sempurna.
                </p>
                
                <div style="
                    background-color: #f0f9fa; 
                    border-left: 5px solid #176369;
                    padding: 12px 15px;
                    border-radius: 8px;
                    margin-bottom: 20px;
                    text-align: left;
                ">
                    <p style="
                        color: #4a5568;
                        font-size: 14px;
                        margin: 0;
                    ">
                        ⏳ Halaman akan dimuat ulang dalam beberapa saat...
                    </p>
                </div>
            </div>
        `,
            confirmButtonText: "Tutup",
            confirmButtonColor: "#176369",
            showCloseButton: false,
            allowOutsideClick: false,
            width: "500px",
            willClose: () => window.location.reload(),
            didOpen: () => {
                const style = document.createElement("style");
                style.textContent = `
                .swal2-popup {
                    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
                    border-radius: 20px;
                    box-shadow: 0 30px 60px rgba(23, 99, 105, 0.15);
                    animation: softBounce 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                }

                @keyframes softBounce {
                    0% { transform: scale(0.8); opacity: 0; }
                    70% { transform: scale(1.03); opacity: 0.9; }
                    100% { transform: scale(1); opacity: 1; }
                }

                .swal2-confirm {
                    padding: 12px 24px !important;
                    font-weight: 700;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    border-radius: 10px;
                    transition: all 0.3s ease;
                }

                .swal2-confirm:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 6px 20px rgba(23, 99, 105, 0.3);
                }

                .swal2-icon.swal2-success {
                    border-color: rgba(23, 99, 105, 0.2) !important;
                }

                .swal2-success-ring {
                    border-color: #176369 !important;
                    opacity: 0.3;
                }
            `;
                document.head.appendChild(style);
            },
        });
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Gagal!",
            html: `
<div style="
    background-color: #fff0f3;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    max-width: 400px;
    margin: 0 auto;
">
    <p style="
        color: #4a4a4a;
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 10px;
    ">
        ${error.message}
    </p>
</div>
`,
            confirmButtonText: "Tutup",
            confirmButtonColor: "#dc2626",
            didOpen: () => {
                const style = document.createElement("style");
                style.textContent = `
    .swal2-popup {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(220, 38, 38, 0.1);
    }
    .swal2-confirm {
        padding: 10px 20px !important;
        font-weight: 600;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }
    .swal2-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.2);
    }
    .swal2-icon.swal2-error {
        margin-bottom: 10px !important;
    }
`;
                document.head.appendChild(style);
            },
        });
    } finally {
        btn.disabled = false;
        btn.innerHTML = "Submit Semua Indikator KATSINOV";
    }
}

 // Initialize AOS (Animate On Scroll)
AOS.init({
    duration: 800,
    offset: 100,
    once: true
});

// Form Interactivity
// document.addEventListener('DOMContentLoaded', () => {
//     const formInputs = document.querySelectorAll('.form-input');

//     formInputs.forEach(input => {
//         input.addEventListener('focus', (e) => {
//             e.target.style.borderColor = 'var(--primary)';
//         });

//         input.addEventListener('blur', (e) => {
//             e.target.style.borderColor = 'var(--background)';
//         });
//     });

//     // Simple form validation (optional)
//     const form = document.querySelector('.form-container');
//     form.addEventListener('submit', (e) => {
//         e.preventDefault();
//         let isValid = true;

//         formInputs.forEach(input => {
//             if (!input.value.trim()) {
//                 input.style.borderColor = '#FF6B6B';
//                 isValid = false;
//             }
//         });

//         if (isValid) {
//             alert('Formulir berhasil disubmit!');
//             // You can add more complex submission logic here
//         }
//     });
// });
