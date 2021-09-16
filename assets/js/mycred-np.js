

function mnp_purchase_points() {
    var userContact = document.getElementById("mnp_near_contact").value;
    var pointsToPurchase = document.getElementById("mnp_points").value;

    if(!userContact) {
        alert('Please insert your near wallet id');
        return;
    }
    if(!pointsToPurchase) {
        alert('Please insert your near wallet id');
        return;
    }

    if( !mnp_assets.mycred_np_admin_account || !mnp_assets.mycred_np_network) {
        alert('Near Credentials are not set up in admin');
        return;
    }
    
    const userContactID = userContact.concat('.', mnp_assets.mycred_np_network);

    const nearConfig = {
        networkId: mnp_assets.mycred_np_network,
        contractName: mnp_assets.mycred_np_admin_account,
        nodeUrl: "https://rpc."+mnp_assets.mycred_np_network+".near.org",
        walletUrl: "https://wallet."+mnp_assets.mycred_np_network+".near.org",
        helperUrl: "https://helper."+mnp_assets.mycred_np_network+".near.org",
        explorerUrl: "https://explorer."+mnp_assets.mycred_np_network+".near.org"
        
      };
    (async function () { 
       
         //const keyPair = nearApi.KeyPair.fromString(mnp_assets.mycred_np_private_key);
        
         const keyStore = new nearApi.keyStores.BrowserLocalStorageKeyStore();
        // await keyStore.setKey(mnp_assets.mycred_np_network, mnp_assets.mycred_np_admin_account, keyPair);
         nearConfig.deps = { keyStore };
       // console.log(keyStore);
       // console.log(nearConfig);
         window.near = await nearApi.connect(nearConfig);
       
       
          const wallet = new nearApi.WalletConnection(window.near);
          const signIn =  wallet.requestSignIn(
            userContactID, // contract requesting access
            );
         //   console.log(signIn);
          const walletAccountId = wallet.getAccountId();
       
          if(wallet.isSignedIn()) {
            
            const walletAccountObj = wallet.account();
           
       
           const adminContactID = mnp_assets.mycred_np_admin_account.concat('.', mnp_assets.mycred_np_network);
           const tokenForPurchase = parseFloat(pointsToPurchase) / parseFloat(mnp_assets.mycred_np_exchange_rate)
           
           const { utils } = nearApi;
           const tokenForPurchasePoints = utils.format.parseNearAmount(String(tokenForPurchase));

           var response = await walletAccountObj.sendMoney(
            adminContactID, // receiver account
            tokenForPurchasePoints // amount in yoctoNEAR
           );
            console.log(response);
            var receipt_id = '';
            if (response.transaction_outcome.outcome.status.SuccessReceiptId) {
                receipt_id = response.transaction_outcome.outcome.status.SuccessReceiptId;
            }

            var data = {
                'action': 'mnp_purchase_points',
                'pointsToPurchase': pointsToPurchase,
                'mrp_nonce': mnp_assets.mycred_np_nonce,
                'tx_receipt_id': receipt_id,
                'tx_response': response
                
            };
            jQuery.post(mnp_assets.ajax_url, data, function(response) {
                
                var response_parsed = JSON.parse(response)
                alert(response_parsed.msg);
            
        
            });
         }
        
         
        
           
       })(window);
}
