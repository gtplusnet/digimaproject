using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Runtime.InteropServices;

internal struct LASTINPUTINFO
{
    public uint cbSize;

    public uint dwTime;
}

namespace DigimaLogTime
{

    public partial class frmMain : Form
    {
        public frmMain()
        {
            InitializeComponent();
        }

        private void frmMain_Load(object sender, EventArgs e)
        {
            this.webBrowser1.Url = new Uri(config.server_url + "/app");

            if(config.testmode != true)
            {
                webBrowser1.AllowWebBrowserDrop = false;
                webBrowser1.IsWebBrowserContextMenuEnabled = false;
                //webBrowser1.WebBrowserShortcutsEnabled = false;
                webBrowser1.ScriptErrorsSuppressed = true;
            }

            webBrowser1.ObjectForScripting = new ScriptManager(this);
        }

        private void button1_Click(object sender, EventArgs e)
        {
        }

        private void timer1_Tick(object sender, EventArgs e)
        {
            this.label1.Text = (IdleTimeFinder.GetIdleTime().ToString());
            var parameters = new object[] { IdleTimeFinder.GetIdleTime().ToString() };
            this.webBrowser1.Document.InvokeScript("idle_from_csharp", parameters);
        }

        private void webBrowser1_DocumentCompleted(object sender, WebBrowserDocumentCompletedEventArgs e)
        {
        }
    }
    public static class Extensions
    {
        [DllImport("user32.dll")]
        private static extern int ShowWindow(IntPtr hWnd, uint Msg);

        private const uint SW_RESTORE = 0x09;

        public static void Restore(this Form form)
        {
            if (form.WindowState == FormWindowState.Minimized)
            {
                ShowWindow(form.Handle, SW_RESTORE);
            }
        }
    }

    // This nested class must be ComVisible for the JavaScript to be able to call it.
    [ComVisible(true)]
    public class ScriptManager
    {
        // Variable to store the form of type Form1.
        private frmMain mForm;

        // Constructor.
        public ScriptManager(frmMain form)
        {
            // Save the form so it can be referenced later.
            mForm = form;
        }
        public void topMostTrue()
        {
            mForm.TopMost = true;
            Extensions.Restore(mForm);
        }
        public void topMostFalse()
        {
            mForm.TopMost = false;
        }
        // This method can be called from JavaScript.
        public void MethodToCallFromScript()
        {
            // Call a method on the form.
            //mForm.topMostTrue;
        }

    }

    public class IdleTimeFinder
    {
        [DllImport("User32.dll")]
        private static extern bool GetLastInputInfo(ref LASTINPUTINFO plii);

        [DllImport("Kernel32.dll")]
        private static extern uint GetLastError();

        public static uint GetIdleTime()
        {
            LASTINPUTINFO lastInPut = new LASTINPUTINFO();
            lastInPut.cbSize = (uint)System.Runtime.InteropServices.Marshal.SizeOf(lastInPut);
            GetLastInputInfo(ref lastInPut);

            return ((uint)Environment.TickCount - lastInPut.dwTime);
        }
        public static long GetLastInputTime()
        {
            LASTINPUTINFO lastInPut = new LASTINPUTINFO();
            lastInPut.cbSize = (uint)System.Runtime.InteropServices.Marshal.SizeOf(lastInPut);
            if (!GetLastInputInfo(ref lastInPut))
            {
                throw new Exception(GetLastError().ToString());
            }
            return lastInPut.dwTime;
        }
    }
}