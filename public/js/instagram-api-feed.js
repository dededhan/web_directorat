document.addEventListener('DOMContentLoaded', function() {
    // Fetch Instagram posts from the API
    fetchInstagramApiPosts();
});

function fetchInstagramApiPosts() {
    fetch('/api/instagram-api-posts')
        .then(response => response.json())
        .then(posts => {
            const container = document.getElementById('instagram-api-feed-container');
            
            // Clear loading placeholders if any
            container.innerHTML = '';
            
            if (posts.length === 0) {
                // Display a message if no posts are found
                container.innerHTML = `
                    <div class="col-span-3 text-center py-8">
                        <p class="text-gray-500">Belum ada postingan Instagram tersedia.</p>
                    </div>
                `;
                return;
            }
            
            // Generate HTML for each post
            posts.forEach((post, index) => {
                const colorGradient = index % 3 === 0 
                    ? 'from-teal-100 to-teal-200' 
                    : (index % 3 === 1 ? 'from-yellow-100 to-yellow-200' : 'from-teal-100 to-blue-200');
                
                const postCard = `
                    <div class="media-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                        <div class="relative pb-[56.25%]">
                            ${post.media_url 
                                ? `<img src="${post.media_url}" alt="${post.title}" class="absolute inset-0 w-full h-full object-cover">` 
                                : `<div class="absolute inset-0 bg-gradient-to-br ${colorGradient} flex items-center justify-center">
                                    <i class="fab fa-instagram text-teal-500 text-5xl opacity-30"></i>
                                   </div>`
                            }
                            <div class="absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-sm font-semibold">
                                Instagram
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center text-gray-500 text-sm">
                                    <i class="fab fa-instagram mr-2"></i>
                                    <span>@dit.isipunj</span>
                                </div>
                                <div class="text-gray-500 text-sm">
                                    ${new Date(post.posted_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'})}
                                </div>
                            </div>
                            <h3 class="font-bold text-teal-800 text-xl mb-2 group-hover:text-yellow-500 transition-colors duration-300">
                                ${post.title}
                            </h3>
                            <p class="text-gray-600 mb-4">
                                ${post.caption.length > 100 ? post.caption.substring(0, 100) + '...' : post.caption}
                            </p>
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <a href="${post.permalink}" target="_blank" class="inline-flex items-center text-teal-600 hover:text-yellow-500 transition-colors duration-300">
                                    <span>Lihat di Instagram</span>
                                    <i class="fas fa-external-link-alt ml-2 text-sm"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                `;
                
                // Add post card to container
                container.innerHTML += postCard;
            });
        })
        .catch(error => {
            console.error('Error fetching Instagram posts:', error);
            const container = document.getElementById('instagram-api-feed-container');
            container.innerHTML = `
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-500">Gagal memuat postingan Instagram. Silakan coba lagi nanti.</p>
                </div>
            `;
        });
}