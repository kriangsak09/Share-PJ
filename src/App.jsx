import { useEffect, useState } from 'react';
import './App.css';
import { GoogleLogin, GoogleLogout } from 'react-google-login';
import { gapi } from 'gapi-script';

function App() {
  const clientId = "516643276798-0fskrc4md13hnh6auparb51ute8e35rf.apps.googleusercontent.com";

  const [profile, setProfile] = useState(null);

  useEffect(() => {
    const initClient = () => {
      gapi.load('client:auth2', () => {
        gapi.client.init({
          clientId: clientId,
          scope: ''
        }).then(() => {
          console.log('Google API initialized');
        }).catch(error => {
          console.error('Error initializing Google API:', error);
        });
      });
    }
    initClient();
  }, []);

  const onSuccess = (res) => {
    setProfile(res.profileObj);
    const url = getRedirectUrl(res.profileObj);
    window.location.href = url; // Redirect to the specified URL with user data
  };

  const onFailure = (res) => {
    console.log('failed', res);
  }

  const logOut = () => {
    setProfile(null);
  }

  const getRedirectUrl = (profile) => {
    const baseUrl = profile.email.endsWith('@gmail.com')
      ? 'http://192.168.56.1/myproject/index.php' // @gmail
      : 'http://192.168.56.1/myproject/learn-reactjs-2024/course-app/addtable.php'; // @mail.rmutk.ac.th // Teacher Page
  
    const params = new URLSearchParams({
      user: profile.email,
      name: profile.name,
      image: profile.imageUrl
    });
  
    return `${baseUrl}?${params.toString()}`;
  };

  return (
    <div className="app-container">
      <h2 className="title">Google Login</h2>
      <br /><br />
      {profile ? (
        <div>
          <img src={profile.imageUrl} alt="user image" />
          <h3>User Logged in</h3>
          <p>Name: {profile.name}</p>
          <p>Email: {profile.email}</p>
          <a
            className="list-group-item list-group-item-action list-group-item-light p-3"
            href={getRedirectUrl(profile)}
          >
            เข้าสู่เว็บไซต์
          </a>
          <br /><br />
          <GoogleLogout
            clientId={clientId}
            buttonText="Log out"
            onLogoutSuccess={logOut}
          />
          <br /><br />
        </div>
      ) : (
        <GoogleLogin
          clientId={clientId}
          buttonText="Sign in with Google"
          onSuccess={onSuccess}
          onFailure={onFailure}
          cookiePolicy={'single_host_origin'}
          isSignedIn={true}
        />
      )}
    </div>
  );
}

export default App;
