using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace DigimaLogTime
{
    public static class config
    {
        // parameterless constructor required for static class
        static config()
        {
            testmode = false;

            if(testmode == true)
            {
                server_url = "http://digimaproject.test";
            }
            else
            {
                server_url = "http://188.166.184.91/";
            }
        }
        

        // public get, and private set for strict access control
        public static string server_url { get; private set; }
        public static Boolean testmode { get; private set; }

        // GlobalInt can be changed only via this method
        public static void SetGlobalURL(string new_server_url)
        {
            server_url = new_server_url;
        }
    }
}