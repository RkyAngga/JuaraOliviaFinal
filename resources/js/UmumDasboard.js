document.addEventListener("DOMContentLoaded", function () {
    // Counter Animation
    const counters = document.querySelectorAll(".counter-value");
    if (counters.length > 0) {
        const duration = 2000;

        counters.forEach((counter) => {
            const target = +counter.getAttribute("data-target");
            let count = 0;
            const increment = target / (duration / 16);

            const animateCounter = () => {
                count += increment;
                if (count < target) {
                    counter.innerText = Math.floor(count);
                    requestAnimationFrame(animateCounter);
                } else {
                    counter.innerText = target;
                }
            };

            animateCounter();
        });
    }

    // Map Initialization
    const mapElement = document.getElementById("map");
    if (mapElement) {
        var map = L.map("map").setView(
            [-7.950756308807206, 112.61804537457287],
            13
        );

        // --- Tambahan: Simpan marker berdasarkan id laporan ---
        window.laporanMarkers = {}; // Global agar bisa diakses dari luar
        window.laporanMapInstance = map; // Simpan instance map global
        // ---

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution:
                '&copy; <a href="https://www.openstreetmap.org/copyright"></a>',
        }).addTo(map);

        // Add Kota Malang GeoJSON layer
        fetch("/export.geojson")
            .then((response) => response.json())
            .then((data) => {
                L.geoJSON(data, {
                    style: function (feature) {
                        return {
                            color: "#FFD700",
                            weight: 2,
                            opacity: 0.8,
                            fillColor: "#FFD700",
                            fillOpacity: 0.1,
                        };
                    },
                    onEachFeature: function (feature, layer) {
                        if (feature.properties && feature.properties.name) {
                            layer.bindPopup(feature.properties.name);
                        }
                    },
                }).addTo(map);
            })
            .catch((error) => console.error("Error loading GeoJSON:", error));

        // Ambil data marker dari database
        fetch("/api/laporan-pengaduan")
            .then((response) => response.json())
            .then((markers) => {
                markers.forEach(function (marker) {
                    // Pilih warna marker sesuai status
                    let color = "yellow";
                    if (marker.status === "Menunggu") color = "yellow";
                    else if (marker.status === "Di Proses") color = "blue";
                    else if (marker.status === "Selesai") color = "green";
                    else if (marker.status === "Ditolak") color = "red";

                    // Custom icon
                    var customIcon = L.divIcon({
                        className: "marker-icon marker-" + color,
                        html: `<div style="background:${color};width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:bold;color:white;font-size:18px;border:2px solid #fff;">${marker.status.charAt(
                            0
                        )}</div>`,
                        iconSize: [30, 30],
                    });

                    // Format tanggal (optional)
                    let waktu = marker.created_at
                        ? new Date(marker.created_at).toLocaleString("id-ID")
                        : "";

                    // Popup detail
                    let trackingUrl = "/login";
                    if (window.isLoggedIn) {
                        if (marker.status === "Menunggu") {
                            trackingUrl = `/masyarakat/laporan/menunggu/${marker.id}`;
                        } else if (marker.status === "Di Proses") {
                            if (marker.sub_status === "menunggu_verifikasi_admin") {
                                trackingUrl = `/masyarakat/laporan/proses/ditindaklanjuti/${marker.id}`;
                            } else {
                                trackingUrl = `/masyarakat/laporan/proses/diselesaikan/${marker.id}`;
                            }
                        } else if (marker.status === "Ditolak") {
                            trackingUrl = `/masyarakat/laporan/ditolak/${marker.id}`;
                        } else if (marker.status === "Selesai") {
                            trackingUrl = `/masyarakat/laporan/ulasan/${marker.id}`;
                        }
                    }
                    let popupContent = `
                        <b>${marker.lokasi}</b><br>
                        <span>Status: <b>${marker.status}</b></span><br>
                        <span>Deskripsi: ${marker.deskripsi || "-"}</span><br>
                        <span>Waktu: ${waktu}</span>
                        <br>
                        <a href="${trackingUrl}" class="text-blue-500 underline" target="_blank">Tracking Laporan</a>
                        &nbsp;|&nbsp;
                        <a href="https://www.google.com/maps?q=${marker.latitude},${marker.longitude}" target="_blank" title="Lihat di Google Maps">
                            <svg xmlns="http://www.w3.org/2000/svg" style="display:inline" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="green">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>
                    `;

                    // --- Tambahan: Simpan marker ke mapping id ---
                    var leafletMarker = L.marker(
                        [marker.latitude, marker.longitude],
                        { icon: customIcon }
                    )
                        .addTo(map)
                        .bindPopup(popupContent);
                    window.laporanMarkers[marker.id] = leafletMarker;
                    // ---
                });

                // Setelah window.laporanMarkers sudah terisi
                const urlParams = new URLSearchParams(window.location.search);
                const focusId = urlParams.get("focus");
                if (focusId && window.focusToMarker) {
                    setTimeout(function () {
                        window.focusToMarker(focusId);
                        // Scroll ke map
                        var mapElement = document.getElementById("map");
                        if (mapElement) {
                            mapElement.scrollIntoView({
                                behavior: "smooth",
                                block: "center",
                            });
                        }
                    }, 500);
                }
            })
            .catch((error) => console.error("Error loading markers:", error));

        // Setelah marker laporan ditambahkan, tambahkan marker dinas
        fetch('/api/marker-dinas')
            .then(response => response.json())
            .then(dinas => {
                if (dinas && dinas.latitude && dinas.longitude) {
                    var dinasIcon = L.icon({
                        iconUrl: '/img/icon/dinas.svg',
                        iconSize: [32, 48],
                        iconAnchor: [16, 48],
                        popupAnchor: [0, -48]
                    });
                    var dinasPopup = `<b>DINAS</b><br>Latitude: ${dinas.latitude}<br>Longitude: ${dinas.longitude}`;
                    L.marker([dinas.latitude, dinas.longitude], { icon: dinasIcon })
                        .addTo(map)
                        .bindPopup(dinasPopup);
                }
            });
        // Tambahkan marker pusat
        fetch('/api/marker-pusat')
            .then(response => response.json())
            .then(pusat => {
                if (pusat && pusat.latitude && pusat.longitude) {
                    var pusatIcon = L.icon({
                        iconUrl: '/img/icon/pemkot.svg',
                        iconSize: [32, 48],
                        iconAnchor: [16, 48],
                        popupAnchor: [0, -48]
                    });
                    var pusatPopup = `<b>PEMERINTAH PUSAT</b><br>Latitude: ${pusat.latitude}<br>Longitude: ${pusat.longitude}`;
                    L.marker([pusat.latitude, pusat.longitude], { icon: pusatIcon })
                        .addTo(map)
                        .bindPopup(pusatPopup);
                }
            });
    }

    // Swiper Initialization
    const swiperElement = document.querySelector(".swiper");
    if (swiperElement) {
        const swiper = new Swiper(".swiper", {
            speed: 400,
            spaceBetween: 30,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            grabCursor: true,
            breakpoints: {
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    }

    // Back to Top Button
    var backToTopBtn = document.getElementById("backToTopBtn");
    if (backToTopBtn) {
        window.addEventListener("scroll", function () {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.remove("hidden");
            } else {
                backToTopBtn.classList.add("hidden");
            }
        });

        backToTopBtn.addEventListener("click", function () {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        });
    }

    // Tambahkan fungsi global agar bisa dipanggil dari card
    // ... existing code ...
    window.focusToMarker = function (id) {
        if (
            window.laporanMarkers &&
            window.laporanMarkers[id] &&
            window.laporanMapInstance
        ) {
            var marker = window.laporanMarkers[id];
            var map = window.laporanMapInstance;
            map.setView(marker.getLatLng(), 18, { animate: true });
            marker.openPopup();
            // Scroll ke map setelah popup dibuka
            var mapElement = document.getElementById("map");
            if (mapElement) {
                mapElement.scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });
            }
        } else {
            alert(
                "Marker tidak ditemukan di peta. Pastikan peta sudah termuat."
            );
        }
    };

    function dataURLtoBlob(dataurl) {
        var arr = dataurl.split(","),
            mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]),
            n = bstr.length,
            u8arr = new Uint8Array(n);
        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new Blob([u8arr], { type: mime });
    }

    document
        .getElementById("pengaduanForm")
        .addEventListener("submit", function (e) {
            e.preventDefault();
            let formData = new FormData();

            const imageData = localStorage.getItem("capturedImageData");
            if (imageData) {
                formData.append(
                    "foto",
                    dataURLtoBlob(imageData),
                    "laporan.jpg"
                );
            }
            formData.append(
                "latitude",
                localStorage.getItem("capturedLatitude")
            );
            formData.append(
                "longitude",
                localStorage.getItem("capturedLongitude")
            );
            formData.append("alamat", document.getElementById("alamat").value);
            formData.append(
                "deskripsi",
                document.getElementById("deskripsi").value
            );
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            // Debug: cek field
            console.log([...formData.entries()]);

            fetch(this.action, {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData,
            })
                .then((res) => {
                    const contentType = res.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        if (res.redirected) {
                            window.location.href = res.url;
                            return;
                        }
                        throw new Error('Server mengirim response tidak valid');
                    }
                    return res.json();
                })
                .then((data) => {
                    if (data.success) {
                        document
                            .getElementById("successModal")
                            .classList.remove("hidden");
                    } else {
                        alert(data.message);
                    }
                })
                .catch((err) => {
                    if (err.message.includes('Unauthorized') || err.message.includes('session')) {
                        alert('Sesi Anda telah berakhir. Silakan login kembali.');
                        window.location.href = '/login';
                        return;
                    }
                    alert("Terjadi kesalahan! " + err.message);
                });
        });
});
