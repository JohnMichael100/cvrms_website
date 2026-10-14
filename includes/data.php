<?php
// includes/data.php - Data management, session tracking and persistence
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('DATA_FILE', __DIR__ . '/storage.json');

function get_initial_data() {
    return [
        'users' => [
            [
                'id' => 1,
                'name' => 'John Lucero Cabilao',
                'email' => 'jolu.cabilao@gmail.com',
                'password' => 'password123',
                'phone' => '+63 912 345 6789',
                'birthdate' => '1998-01-15',
                'gender' => 'Male',
                'address' => 'Punta Engaño, Lapu-Lapu City, Cebu, Philippines',
                'member_id' => 'CV-8829',
                'pfp' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80',
                'total_bookings' => 3,
                'nights_stayed' => 5
            ]
        ],
        'announcements' => [
            [
                'id' => 1,
                'tag' => 'Tournament Announcement',
                'title' => 'Annual Cebu Open Pickleball Championship 2026',
                'short_desc' => 'Registration is officially open for the CasaVista Masters. Featuring Men\'s, Women\'s, and Mixed Open brackets with standard tournament rules and cash awards.',
                'full_desc' => "We are honored to host the 2026 CasaVista Masters Tournament across all 3 certified hardcourts this August.\n\nTournament Schedule & Details:\n• Aug 21-22: Mixed Doubles Prelims & Quarter-finals\n• Aug 23: Championship Finals & Sunset Awards Reception\n\nComplimentary tournament jerseys, hydration stations, and access to the recovery cold plunge pool are included for all registered players. Inquire through front desk or submit your doubles roster today.",
                'date' => 'September 27, 2026',
                'author' => 'Sports & Recreation Director',
                'image' => 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?auto=format&fit=crop&w=1200&q=80'
            ],
            [
                'id' => 2,
                'tag' => 'Facility Advisory',
                'title' => 'Main Infinity Pool & Coastal Deck Filtration Upgrade',
                'short_desc' => 'Scheduled eco-filtration maintenance will take place on Tuesday morning from 7:00 AM to 11:30 AM to maintain pristine seawater clarity.',
                'full_desc' => "To uphold our rigorous environmental sanitation standards, our coastal infinity pool filtration undergoes preventative maintenance every Tuesday morning.\n\nWhat to expect:\n• Private villa plunge pools and cabanas remain 100% operational.\n• The resort beachfront lounge and sports courts will be open during regular operational hours.\n• Refreshment bar will serve complimentary iced tea for affected guests at the garden deck.",
                'date' => 'August 14, 2026',
                'author' => 'Resort Operations Office',
                'image' => 'https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?auto=format&fit=crop&w=1200&q=80'
            ],
            [
                'id' => 3,
                'tag' => 'Culinary Experience',
                'title' => 'Seaside Acoustic Dinners & Farm-To-Table Grill',
                'short_desc' => 'Join our culinary team every Friday and Saturday evening for fresh Mactan seafood skewers, organic farm produce, and live acoustic lounge music.',
                'full_desc' => "Spend sunset beneath the palms at our beachfront terrace with an exclusive culinary showcase by Chef Marco Rivera.\n\nFeatures:\n• Catch-of-the-day yellowfin tuna and tiger prawns grilled over coconut husk embers\n• Organic greens harvested directly from Central Visayas partner farms\n• Live bossa nova and acoustic sets from 6:00 PM to 9:30 PM",
                'date' => 'October 01, 2026',
                'author' => 'Executive Chef',
                'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'catalog' => [
            // 3 Rooms
            [
                'id' => 101,
                'type' => 'ROOMS',
                'title' => 'Villa Suite 101 (Seaview)',
                'subtitle' => 'King Bed • Panoramic Ocean Balcony • Marble Bath',
                'rate' => 4500,
                'status' => 'Available',
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                'description' => 'A serene 72 sqm oceanfront sanctuary featuring floor-to-ceiling glass doors overlooking the Cebu strait, a deep soaking tub, mini-bar, and custom teak furnishings.'
            ],
            [
                'id' => 102,
                'type' => 'ROOMS',
                'title' => 'Villa Deluxe 102 (Garden)',
                'subtitle' => 'Queen Bed • Tropical Flora Views • Direct Pool Pathway',
                'rate' => 3800,
                'status' => 'Under Maintenance',
                'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Surrounded by lush native garden greenery with a private stone terrace and immediate walk-in access to the resort\'s central infinity pool.'
            ],
            [
                'id' => 103,
                'type' => 'ROOMS',
                'title' => 'Family Loft 201',
                'subtitle' => '2 Queen Beds • Double-Height Ceilings • Kitchenette',
                'rate' => 6800,
                'status' => 'Booked',
                'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Two-story architectural loft built for 4 to 6 guests. Features high cathedral ceilings, a dining space, induction cooktop, and generous living area.'
            ],
            // 3 Pickleball Courts
            [
                'id' => 201,
                'type' => 'PICKLEBALL',
                'title' => 'Pickleball Court 1 (Pro Hardcourt)',
                'subtitle' => 'Covered Canopy • Tournament Non-Glare Lighting',
                'rate' => 350,
                'status' => 'Available',
                'image' => 'https://images.unsplash.com/photo-1622279457486-62dcc4a431d6?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Cushioned acrylic hardcourt certified to competitive standards. Engineered with high-traction surface texture and shadow-free LED night illumination.'
            ],
            [
                'id' => 202,
                'type' => 'PICKLEBALL',
                'title' => 'Pickleball Court 2 (Open Air Breeze)',
                'subtitle' => 'Outdoor • Shaded Players Bench • Ocean Breeze',
                'rate' => 350,
                'status' => 'Available',
                'image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Open-air court situated along the sea-facing boundary. Features pro-spec net posts, shaded player seating, and complimentary court-side water dispensers.'
            ],
            [
                'id' => 203,
                'type' => 'PICKLEBALL',
                'title' => 'Pickleball Court 3 (Training & Ball Machine)',
                'subtitle' => 'Automatic Ball Feeder • Rebound Wall • Instructor Ready',
                'rate' => 450,
                'status' => 'Available',
                'image' => 'https://images.unsplash.com/photo-1595435934249-5df7ed86e1c0?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Dedicated skill development court equipped with a programmable ball feed system and high-density practice rebound wall for single or coach sessions.'
            ],
            // 1 Basketball Court
            [
                'id' => 301,
                'type' => 'BASKETBALL',
                'title' => 'FIBA Regulation Basketball Court',
                'subtitle' => 'Hardwood Finish • Shatterproof Glass Backboards • Scoreboard',
                'rate' => 800,
                'status' => 'Available',
                'image' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Full-size basketball facility featuring shock-attenuating flooring, pro spring-loaded breakaway rims, regulation glass backboards, and digital scoring.'
            ],
            // Buyout
            [
                'id' => 401,
                'type' => 'BUYOUT',
                'title' => 'Complete Resort Buyout (Private Oasis)',
                'subtitle' => 'All 3 Luxury Villas • All 4 Courts • Infinity Pool & Grounds',
                'rate' => 35000,
                'status' => 'Available',
                'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1600&q=80',
                'description' => 'Reserve the entire CasaVista property exclusively. Includes private occupancy of all villas (up to 16 guests), unrestricted sports court use, and dedicated private concierge.'
            ]
        ],
        'bookings' => [
            [
                'id' => 'BK-1001',
                'user_id' => 1,
                'title' => 'Villa Suite 101 & Pickleball Court 1',
                'type' => 'Upcoming',
                'check_in' => '2:00 PM',
                'check_out' => '12:00 PM',
                'date' => 'AUG 10, 2026',
                'capacity' => 'Villa Suite 101 (King Bed) + 1-Hour Court Access',
                'payment' => 'GCash Verified (Ref: 981244301)',
                'price' => '₱4,850',
                'status' => 'Confirmed'
            ],
            [
                'id' => 'BK-1002',
                'user_id' => 1,
                'title' => 'Family Loft 201',
                'type' => 'Upcoming',
                'check_in' => '2:00 PM',
                'check_out' => '12:00 PM',
                'date' => 'Sep 26, 2026',
                'capacity' => '4-6 Guests • 2 Queen Beds • Kitchenette Included',
                'payment' => 'Credit Card (Mastercard •••• 4419)',
                'price' => '₱6,800',
                'status' => 'Confirmed'
            ],
            [
                'id' => 'BK-1003',
                'user_id' => 1,
                'title' => 'Pickleball Court 1 (1 Hour Rally)',
                'type' => 'Past',
                'check_in' => '3:00 PM',
                'check_out' => '4:00 PM',
                'date' => 'Jul 15, 2026',
                'capacity' => '4 Players • Paddle Rental Included',
                'payment' => 'Maya E-Wallet Paid',
                'price' => '₱350',
                'status' => 'Completed'
            ],
            [
                'id' => 'BK-1004',
                'user_id' => 1,
                'title' => 'FIBA Basketball Court Full Rental',
                'type' => 'Cancelled',
                'check_in' => '5:00 PM',
                'check_out' => '7:00 PM',
                'date' => 'Jun 02, 2026',
                'capacity' => '10 Players • 2-Hour Evening Session',
                'payment' => 'Full Refund Processed',
                'price' => '₱1,600',
                'status' => 'Cancelled'
            ]
        ]
    ];
}

function load_data() {
    if (!file_exists(DATA_FILE)) {
        $data = get_initial_data();
        save_data($data);
        return $data;
    }
    $json = file_get_contents(DATA_FILE);
    $data = json_decode($json, true);
    return $data ? $data : get_initial_data();
}

function save_data($data) {
    file_put_contents(DATA_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

function get_current_user_data() {
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    $data = load_data();
    foreach ($data['users'] as $u) {
        if ($u['id'] == $_SESSION['user_id']) {
            return $u;
        }
    }
    return $data['users'][0] ?? null;
}

function require_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}
?>
