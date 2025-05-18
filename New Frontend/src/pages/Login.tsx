import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { Eye, EyeOff } from 'lucide-react';
import Button from '../components/ui/Button';

const Login: React.FC = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [isLoading, setIsLoading] = useState(false);
  const navigate = useNavigate();
  
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setIsLoading(true);
    
    // Simulate authentication
    setTimeout(() => {
      setIsLoading(false);
      navigate('/');
    }, 1500);
  };
  
  return (
    <div className="min-h-screen flex">
      {/* Left Panel - Login Form */}
      <div className="flex-1 flex items-center justify-center p-8">
        <div className="w-full max-w-md">
          <div className="mb-8">
            <h1 className="text-3xl font-bold text-gray-900">Login</h1>
            <p className="text-gray-600 mt-2">Welcome back! Please enter your credentials</p>
          </div>
          
          <form onSubmit={handleSubmit}>
            <div className="space-y-4">
              {/* Email Input */}
              <div>
                <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-1">
                  Email address
                </label>
                <input
                  id="email"
                  type="email"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors"
                  placeholder="Enter your email"
                  required
                />
              </div>
              
              {/* Password Input */}
              <div>
                <label htmlFor="password" className="block text-sm font-medium text-gray-700 mb-1">
                  Password
                </label>
                <div className="relative">
                  <input
                    id="password"
                    type={showPassword ? 'text' : 'password'}
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors"
                    placeholder="Enter your password"
                    required
                  />
                  <button
                    type="button"
                    className="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                    onClick={() => setShowPassword(!showPassword)}
                  >
                    {showPassword ? <EyeOff size={18} /> : <Eye size={18} />}
                  </button>
                </div>
              </div>
              
              {/* Forgot Password */}
              <div className="flex justify-end">
                <a href="/forgot-password" className="text-sm text-purple-600 hover:underline">
                  Forgot Password?
                </a>
              </div>
              
              {/* Login Button */}
              <Button type="submit" fullWidth isLoading={isLoading}>
                Login
              </Button>
            </div>
          </form>
          
          {/* Divider */}
          <div className="flex items-center my-6">
            <div className="flex-1 border-t border-gray-300"></div>
            <div className="px-4 text-sm text-gray-500">or sign in with</div>
            <div className="flex-1 border-t border-gray-300"></div>
          </div>
          
          {/* Social Login Buttons */}
          <div className="flex space-x-3">
            <button className="flex-1 flex justify-center items-center py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
              <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/google/google-original.svg" alt="Google" className="w-5 h-5" />
            </button>
            <button className="flex-1 flex justify-center items-center py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
              <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/github/github-original.svg" alt="GitHub" className="w-5 h-5" />
            </button>
            <button className="flex-1 flex justify-center items-center py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
              <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/linkedin/linkedin-original.svg" alt="LinkedIn" className="w-5 h-5" />
            </button>
          </div>
          
          {/* Sign Up */}
          <div className="mt-8 text-center">
            <p className="text-gray-600">
              Don't have an account?{' '}
              <a href="/signup" className="text-purple-600 font-medium hover:underline">
                Sign up
              </a>
            </p>
          </div>
        </div>
      </div>
      
      {/* Right Panel - Welcome Banner */}
      <div className="hidden md:flex md:flex-1 bg-purple-600 text-white p-8 items-center justify-center">
        <div className="max-w-md">
          <h1 className="text-4xl font-bold mb-4">
            Welcome to Student Portal
          </h1>
          <p className="text-purple-100 text-lg mb-8">
            Login to access your account and student resources
          </p>
          
          {/* Illustration */}
          <div className="flex justify-center">
            <img 
              src="https://images.pexels.com/photos/8471767/pexels-photo-8471767.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" 
              alt="Students working on laptops" 
              className="max-w-full h-auto rounded-lg"
            />
          </div>
        </div>
      </div>
    </div>
  );
};

export default Login;