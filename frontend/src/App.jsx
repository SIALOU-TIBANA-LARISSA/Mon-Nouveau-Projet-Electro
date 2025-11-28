import { useState, useEffect } from 'react';
import axios from 'axios';
import { Home, LogIn, LayoutDashboard, Menu, X, ShoppingCart } from 'lucide-react';

// URL de base de l'API lue depuis le fichier .env
const API_URL = import.meta.env.VITE_API_BASE_URL;

// Définition des pages de l'application (utilisation simple d'un état pour la navigation)
const PAGES = {
  HOME: 'home',
  LOGIN: 'login',
  REGISTER: 'register',
  CATALOG: 'catalog',
  DASHBOARD: 'dashboard',
};

// Composant principal de l'application
const App = () => {
  const [currentPage, setCurrentPage] = useState(PAGES.HOME);
  const [apiStatus, setApiStatus] = useState('Vérification...');
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [isLoggedIn, setIsLoggedIn] = useState(false); // Simulateur d'état d'authentification
  const [userRole, setUserRole] = useState('Client'); // Simule le rôle de l'utilisateur

  // Fonction de test de la connexion API
  const checkApiStatus = async () => {
    try {
      // Tente d'accéder à une route publique (comme /categories) pour vérifier la santé du backend.
      const response = await axios.get(`${API_URL}/categories`);
      if (response.status === 200) {
        setApiStatus('API Connectée avec Succès (Code 200) !');
      } else {
        setApiStatus(`API Répond, mais avec un statut inattendu : ${response.status}`);
      }
    } catch (error) {
      console.error("Erreur de connexion API:", error);
      // S'affiche si Docker n'est pas lancé, si le port 8000 est bloqué, ou si .env est mal configuré.
      setApiStatus(`ERREUR de Connexion: L'API n'est pas accessible à ${API_URL}. (Vérifiez votre Docker)`);
    }
  };

  useEffect(() => {
    // Exécuter le test API au chargement de l'application
    checkApiStatus(); 
  }, []);

  // Composant affiché en fonction de la page sélectionnée
  const renderPage = () => {
    switch (currentPage) {
      case PAGES.HOME:
        return <div className="p-8 text-center">Bienvenue sur Electro V2 ! Explorez notre catalogue.</div>;
      case PAGES.CATALOG:
        return <div className="p-8">Catalogue de Produits (Liste publique)</div>;
      case PAGES.LOGIN:
        return <div className="p-8">Page de Connexion</div>;
      case PAGES.REGISTER:
        return <div className="p-8">Page d'Inscription</div>;
      case PAGES.DASHBOARD:
        if (userRole === 'Admin') {
          return <div className="p-8 bg-red-50 text-red-700">Tableau de Bord ADMINISTRATEUR. Gestion des Produits et Catégories.</div>;
        }
        return <div className="p-8 bg-yellow-50 text-yellow-700">Accès Refusé. Seuls les administrateurs y ont accès.</div>;
      default:
        return <div className="p-8">Page non trouvée.</div>;
    }
  };

  const navItems = [
    { name: 'Accueil', icon: Home, page: PAGES.HOME, requiresAuth: false },
    { name: 'Catalogue', icon: ShoppingCart, page: PAGES.CATALOG, requiresAuth: false },
    { name: 'Dashboard Admin', icon: LayoutDashboard, page: PAGES.DASHBOARD, requiresAuth: true, requiredRole: 'Admin' },
  ];

  const authItems = isLoggedIn ? (
    <>
      <button className="w-full text-left p-3 hover:bg-red-600 rounded-md">Déconnexion</button>
      <span className="mt-2 text-sm text-gray-400">Rôle: {userRole}</span>
    </>
  ) : (
    <>
      <button onClick={() => { setCurrentPage(PAGES.LOGIN); setIsMenuOpen(false); }} className="w-full text-left p-3 hover:bg-gray-700 rounded-md flex items-center gap-2">
        <LogIn size={16} /> Connexion
      </button>
      <button onClick={() => { setCurrentPage(PAGES.REGISTER); setIsMenuOpen(false); }} className="w-full text-left p-3 hover:bg-gray-700 rounded-md">Inscription</button>
    </>
  );

  return (
    <div className="min-h-screen bg-gray-100 font-sans">
      {/* Barre de navigation fixe */}
      <header className="bg-gray-800 text-white shadow-lg sticky top-0 z-10">
        <div className="container mx-auto p-4 flex justify-between items-center">
          {/* Logo et titre */}
          <div 
            className="text-2xl font-bold cursor-pointer transition duration-300 hover:text-indigo-400"
            onClick={() => setCurrentPage(PAGES.HOME)}
          >
            Electro V2 Store
          </div>

          {/* Menu Desktop */}
          <nav className="hidden md:flex space-x-6 items-center">
            {navItems.map(item => (
              <a 
                key={item.page}
                onClick={() => setCurrentPage(item.page)}
                className="flex items-center gap-1 cursor-pointer hover:text-indigo-400 transition duration-300 p-2 rounded-md"
              >
                <item.icon size={18} />
                {item.name}
              </a>
            ))}
            {isLoggedIn ? (
              <button className="bg-red-500 hover:bg-red-600 transition duration-300 px-4 py-2 rounded-full text-sm font-semibold ml-4">Déconnexion ({userRole})</button>
            ) : (
              <div className="space-x-4 ml-4">
                <button 
                  onClick={() => setCurrentPage(PAGES.LOGIN)} 
                  className="px-4 py-2 text-indigo-400 border border-indigo-400 rounded-full hover:bg-indigo-400 hover:text-white transition duration-300"
                >
                  Connexion
                </button>
                <button 
                  onClick={() => setCurrentPage(PAGES.REGISTER)} 
                  className="px-4 py-2 bg-indigo-500 rounded-full hover:bg-indigo-600 transition duration-300 font-semibold"
                >
                  Inscription
                </button>
              </div>
            )}
          </nav>

          {/* Bouton Menu Mobile */}
          <button 
            className="md:hidden p-2 rounded-md hover:bg-gray-700 transition duration-300"
            onClick={() => setIsMenuOpen(!isMenuOpen)}
          >
            {isMenuOpen ? <X size={24} /> : <Menu size={24} />}
          </button>
        </div>
      </header>

      {/* Menu Mobile Slide-out */}
      {isMenuOpen && (
        <div className="md:hidden bg-gray-900 text-white p-4 fixed w-full z-10 shadow-xl">
          <nav className="flex flex-col space-y-2">
            {navItems.map(item => (
              <a 
                key={item.page}
                onClick={() => { setCurrentPage(item.page); setIsMenuOpen(false); }}
                className="flex items-center gap-2 p-3 hover:bg-gray-700 rounded-md transition duration-300"
              >
                <item.icon size={18} />
                {item.name}
              </a>
            ))}
            <div className="pt-4 border-t border-gray-700">
                {authItems}
            </div>
          </nav>
        </div>
      )}

      {/* Contenu Principal */}
      <main className="container mx-auto p-4 md:p-8">
        
        {/* Barre de statut API (Feedback critique) */}
        <div className={`p-4 mb-6 rounded-lg shadow-md ${
            apiStatus.startsWith('API Connectée') ? 'bg-green-100 text-green-700 border border-green-300' : 
            apiStatus.startsWith('API Répond') ? 'bg-yellow-100 text-yellow-700 border border-yellow-300' :
            'bg-red-100 text-red-700 border border-red-300'
        }`}>
          <div className="font-semibold">Statut de l'API Laravel :</div>
          <p className="text-sm">{apiStatus}</p>
        </div>
        
        {/* Affichage de la page sélectionnée */}
        <div className="bg-white p-6 rounded-xl shadow-2xl min-h-[60vh]">
            <h1 className="text-3xl font-extrabold text-gray-800 mb-6 border-b pb-2">
                {navItems.find(item => item.page === currentPage)?.name || currentPage.charAt(0).toUpperCase() + currentPage.slice(1)}
            </h1>
            {renderPage()}
        </div>
      </main>

      {/* Footer */}
      <footer className="bg-gray-800 text-white text-center p-4 mt-8">
        <p>© 2025 Electro V2. Architecture React & Laravel.</p>
      </footer>
    </div>
  );
};

export default App;