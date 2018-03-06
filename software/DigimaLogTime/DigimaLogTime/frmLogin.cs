using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;


namespace DigimaLogTime
{
    public partial class frmLogin : Form
    {
        public frmLogin()
        {
            InitializeComponent();
        }

        private void btnLogin_Click(object sender, EventArgs e)
        {
            var login_url = config.server_url + "/rest/login";
            MessageBox.Show(login_url);
            this.Visible = false;
            var frmMain = new frmMain();
            frmMain.Show();
        }
    }
}
